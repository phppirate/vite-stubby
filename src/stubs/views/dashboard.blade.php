<!DOCTYPE html>
<html lang="en" class="h-screen w-screen p-0 m-0">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    {{ vite_assets() }}
</head>
<body class="bg-c1-100 h-screen w-screen p-0 m-0 text-c2-100">
    <div id="app">
        <!-- VUE APP LOADS HERE -->
    </div>
</body>
</html>
