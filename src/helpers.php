<?php

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

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
            <script type="module" src="http://localhost:3000/resources/ts/app.ts"></script>
        HTML);
    }

    $manifest = json_decode(file_get_contents(
        public_path('build/manifest.json')
    ), true);

    if ($cssOnly) {
        return new HtmlString("<link rel='stylesheet' href='/build/{$manifest['resources/ts/app.ts']['css'][0]}'>");
    }

    return new HtmlString("<script type='module' src='/build/{$manifest['resources/ts/app.ts']['file']}'></script><link rel='stylesheet' href='/build/{$manifest['resources/ts/app.ts']['css'][0]}'>");
}
