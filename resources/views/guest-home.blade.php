<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Convidado</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-800 text-white">
    <header class="p-6 bg-gray-900 text-center">
        <h1 class="text-3xl font-bold">Bem-vindo, Convidado!</h1>
    </header>
    <main class="p-6">
        <p class="text-lg text-center">Aqui estão suas funcionalidades e informações.</p>
    </main>

    <form method="POST" action="{{ route('logout') }}" class="mt-4">
        @csrf
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
            Logout
        </button>
    </form>
</body>

</html>