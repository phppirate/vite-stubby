<?php

namespace Phppirate\ViteStubby;

use Illuminate\Support\ServiceProvider;
use Phppirate\ViteStubby\Commands\InstallCommand;

class ViteStubbyProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        require_once(__DIR__.'/helpers.php');
        $this->commands([
            InstallCommand::class
        ]);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
