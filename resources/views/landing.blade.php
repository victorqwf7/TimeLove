<!-- resources/views/landing.blade.php -->

@extends('layouts.guest-layout')

@section('content')

<!-- Tela Inicial Preenchendo 100% da Altura da Tela -->
<section class="w-full h-screen bg-gray-900 text-white flex items-center justify-center px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center w-full max-w-6xl">

        <!-- Coluna Esquerda: Texto Chamativo -->
        <div class="space-y-6">
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight">
                Eternize seus Momentos com o <span class="text-rose-500">TimeLove ❤️</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300">
                Crie cápsulas do tempo digitais, adicione fotos, vídeos e mensagens para guardar suas memórias mais
                especiais.
            </p>
            <a href="{{ route('register') }}"
                class="inline-block bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300">
                Comece Agora
            </a>
        </div>

        <!-- Coluna Direita: Ilustração/Exemplo Visual -->
        <div class="flex justify-center">
            <div class="w-full max-w-md h-96 bg-gray-800 rounded-lg shadow-lg overflow-hidden relative">
                <!-- Imagem Local ou Padrão -->
                <img src="{{ asset('landing.jpg') }}" alt="Exemplo Cápsula"
                    class="w-full h-full object-cover">

                <!-- Sobreposição com Texto -->
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4">
                    <h3 class="font-bold">Sua Cápsula</h3>
                    <p class="text-sm">Adicione fotos, vídeos e guarde momentos especiais para sempre.</p>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection