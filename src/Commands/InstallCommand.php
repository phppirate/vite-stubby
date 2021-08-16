<?php

namespace Phppirate\ViteStubby\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stubby:install {--theme-builder : Use Theme Builder to automatically use slack style theming}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Vite Stubby Laravel Scaffolding';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if($this->hasRun() && !$this->confirm('It Looks Like Stubby was already run. would you like to run it again?', false)) {
            return;
        }

        $this->updateNodePackages(function ($packages) {
            return [
                '@tailwindcss/forms' => '^0.2.1',
                '@tailwindcss/typography' => '^0.4.1',
                '@tailwindcss/line-clamp' => '^0.2.1',
                'autoprefixer' => '^10.3.0',
                'postcss' => '^8.3.5',
                'postcss-import' => '^14.0.2',
                'postcss-nesting' => '^8.0.1',
                'date-fns' => '^2.22.1',
                'tailwindcss' => '^2.2.4',
                '@vue/compiler-sfc' => '^3.1.4',
                '@vitejs/plugin-vue' => '^1.2.4',
                'vite' => '^2.4.1',
                'vue' => '^3.1.4',
                'vue-router' => '^4.0.10',
                'vuex' => '^4.0.2',
                'axios' => '^0.21',
                'lodash' => '^4.17.19',
            ];
        });

        $this->updateNodeScripts(function($scripts){
            return [
                'dev' => 'npm run development',
                'development' => 'vite',
                'prod' => 'npm run production',
                'production' => 'vite build',
            ];
        });

        // Routes
        copy(__DIR__ . '/../stubs/routes/web.php', base_path('routes/web.php'));
        copy(__DIR__ . '/../stubs/routes/auth.php', base_path('routes/auth.php'));

        // CSS
        (new Filesystem)->ensureDirectoryExists(resource_path('css'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../stubs/css', resource_path('css'));

        // TypeScript
        (new Filesystem)->ensureDirectoryExists(resource_path('ts'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../stubs/ts', resource_path('ts'));

        // Views
        (new Filesystem)->ensureDirectoryExists(resource_path('views'));
        (new Filesystem)->copyDirectory(__DIR__ . '/../stubs/views', resource_path('views'));

        // Base Files
        copy(__DIR__ . '/../stubs/.prettierrc.json', base_path('.prettierrc.json'));
        copy(__DIR__ . '/../stubs/postcss.config.js', base_path('postcss.config.js'));
        copy(__DIR__ . '/../stubs/tsconfig.json', base_path('tsconfig.json'));
        copy(__DIR__ . '/../stubs/vite.config.js', base_path('vite.config.js'));

        // // Inculde Theme Builder
        // if ($this->option('theme-builder')) {
        //     copy(__DIR__ . '/../stubs/app/ThemeBuilder.php', app_path('ThemeBuilder.php'));
        //     copy(__DIR__ . '/../stubs/app/helpers-tb.php', app_path('helpers.php'));
        //     copy(__DIR__ . '/../stubs/ThemeBuilder.js', base_path('ThemeBuilder.js'));
        // } else {
        //     copy(__DIR__ . '/../stubs/app/helpers.php', app_path('helpers.php'));
        // }

    }







    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(file_get_contents(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }

    protected static function updateNodeScripts(callable $callback, $dev = true)
    {
        if (!file_exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = 'scripts';

        $scripts = json_decode(file_get_contents(base_path('package.json')), true);

        $scripts[$configurationKey] = $callback(
            array_key_exists($configurationKey, $scripts) ? $scripts[$configurationKey] : [],
            $configurationKey
        );

        ksort($scripts[$configurationKey]);

        file_put_contents(
            base_path('package.json'),
            json_encode($scripts, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL
        );
    }


    /**
     * Installs the given Composer Packages into the application.
     *
     * @param  mixed  $packages
     * @return void
     */
    protected function requireComposerPackages($packages)
    {
        $composer = $this->option('composer');

        if ($composer !== 'global') {
            $command = ['php', $composer, 'require'];
        }

        $command = array_merge(
            $command ?? ['composer', 'require'],
            is_array($packages) ? $packages : func_get_args()
        );

        (new Process($command, base_path(), ['COMPOSER_MEMORY_LIMIT' => '-1']))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    protected static function flushNodeModules()
    {
        tap(new Filesystem, function ($files) {
            $files->deleteDirectory(base_path('node_modules'));

            $files->delete(base_path('yarn.lock'));
            $files->delete(base_path('package-lock.json'));
        });
    }

    /**
     * Replace a given string within a given file.
     *
     * @param  string  $search
     * @param  string  $replace
     * @param  string  $path
     * @return void
     */
    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }

    protected static function hasRun(){
        return file_exists(base_path('vite.config.js'));
    }
    
}
