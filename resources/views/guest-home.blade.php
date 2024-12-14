<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TimeLove - Tela de Guests</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Bem-vindo, Convidado!</h1>

        <div class="text-center mb-4">
            <p class="text-gray-600">Você está na tela de convidados. Aproveite sua visita ao TimeLove.</p>
        </div>

        <!-- Formulário de logout -->
        <div class="text-center mt-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="bg-blue-500 text-white py-2 px-4 rounded-full hover:bg-blue-700 transition duration-200">Logout</button>
            </form>
        </div>
    </div>
</body>

</html>