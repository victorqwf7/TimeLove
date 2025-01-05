<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeLove - Tela do criador</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-slate-900 m-4">
    @yield('header')
    @yield('content')
    @include('components.footer')
</body>

</html>