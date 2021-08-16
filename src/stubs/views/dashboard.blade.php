<!DOCTYPE html>
<html lang="en" class="h-screen w-screen p-0 m-0">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <style>
        body {
            /*
            Night Owl
            #011627,#E6E6E6,#011627,#89A4BB,#0166DA,#FFFFFF
            ASH
            #FFFFFF,#44494D,#EDEEF3,#44494D,#475BA1,#FFFFFF
             */
             {{-- {{ generateCssFromTheme("#FFFFFF,#44494D,#EDEEF3,#44494D,#d92025,#FFFFFF") }} --}}
             {{ generateCssFromTheme(getTheme('Scout')) }}
             {{-- {{ generateCssFromTheme("#011627,#E6E6E6,#011627,#89A4BB,#0166DA,#FFFFFF") }} --}}
             {{-- {{ generateCssFromTheme("#FFFFFF,#44494D,#EDEEF3,#44494D,#475BA1,#FFFFFF") }} --}}
        }
    </style>
    {{ vite_assets() }}
</head>
<body class="bg-c1-100 h-screen w-screen p-0 m-0 text-c2-100">
    <div id="app">
        <!-- VUE APP LOADS HERE -->
    </div>
</body>
</html>
