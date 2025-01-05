<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TimeLove') }} - Autenticação</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md px-6 py-8 bg-gray-800 rounded-lg shadow-lg">
        @yield('content')
    </div>
</body>

</html>