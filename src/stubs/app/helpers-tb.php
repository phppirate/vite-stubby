<?php

use App\ThemeBuilder;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\Http;

function vite_assets($cssOnly = false)
{
    $devServerIsRunning = false;

    if (app()->environment('local')) {
        try {
            Http::get('http://localhost:3000');
            $devServerIsRunning = true;
        } catch (Exception $e) {
        }
    }

    if ($devServerIsRunning) {
        return new HtmlString(<<<HTML
            <script type="module" src="http://localhost:3000/@vite/client"></script>
            <script type="module" src="http://localhost:3000/resources/js/app.ts"></script>
        HTML);
    }

    $manifest = json_decode(file_get_contents(
        public_path('build/manifest.json')
    ), true);

    if ($cssOnly) {
        return new HtmlString("<link rel='stylesheet' href='/build/{$manifest['resources/js/app.ts']['css'][0]}'>");
    }

    return new HtmlString("<script type='module' src='/build/{$manifest['resources/js/app.ts']['file']}'></script><link rel='stylesheet' href='/build/{$manifest['resources/js/app.ts']['css'][0]}'>");
}

function hex2rgba($color, $opacity = false) {
 
    $default = 'rgb(0,0,0)';
 
    //Return default if no color provided
    if(empty($color))
          return $default; 
 
    //Sanitize $color if "#" is provided 
        if ($color[0] == '#' ) {
            $color = substr( $color, 1 );
        }
 
        //Check if color has 6 or 3 characters and get values
        if (strlen($color) == 6) {
                $hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
        } elseif ( strlen( $color ) == 3 ) {
                $hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
        } else {
                return $default;
        }
 
        //Convert hexadec to rgb
        $rgb =  array_map('hexdec', $hex);
 
        //Check if opacity is set(rgba or rgb)
        if($opacity){
            $output = 'rgba('.implode(",",$rgb).','.$opacity.')';
        } else {
            $output = 'rgb('.implode(",",$rgb).')';
        }
 
        //Return rgb(a) color string
        return $output;
}


function generateCssFromTheme(string $theme): String
{
    // , 'var(--tw-text-opacity, var(--tw-bg-opacity))'
    $theme = new ThemeBuilder($theme);
    return $theme->generateCss();
}


function getTheme($name) {
    $themes = json_decode(file_get_contents(storage_path('app/themes.json')), true);
    return $themes[$name];
}
