<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'TimeLove') }} - Autenticação</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 m-4">
    @yield('header')
    @yield('content')
</body>

</html>