<!-- resources/views/criador-home.blade.php -->
<x-app-layout>
    <!-- Header personalizado -->
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight">
            Bem-vindo à sua página Criador
        </h2>
    </x-slot>

    <!-- Corpo da página com fundo escuro -->
    <div class="bg-gray-900 text-gray-100 min-h-screen">
        <div class="max-w-7xl mx-auto py-12 px-6">
            <h1 class="text-4xl font-bold text-center mb-6">
                Página Criador
            </h1>
            <p class="text-center text-lg">
                Este é o ponto de partida para o conteúdo exclusivo dos criadores.
            </p>
            <!-- Botão para ir para a página de dashboard -->
            <div class="mt-4 text-center">
                <a href="{{ route('dashboard') }}" class="inline-block py-2">
                    Ir para página de dashboard.
                </a>
            </div>
        </div>

    </div>
</x-app-layout>