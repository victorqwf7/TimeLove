@extends('layouts.guest-layout')

@section('content')

<!-- 🌟 Seção Hero -->
<section class="w-full h-screen bg-gray-900 text-white flex items-center justify-center px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center w-full max-w-6xl">
        <!-- Coluna Esquerda: Texto Chamativo -->
        <div class="space-y-6">
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mt-10">
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
                <img src="{{ asset('landing.jpg') }}" alt="Exemplo Cápsula" class="w-full h-full object-cover">
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-50 text-white p-4">
                    <h3 class="font-bold">Sua Cápsula</h3>
                    <p class="text-sm">Adicione fotos, vídeos e guarde momentos especiais para sempre.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- 🚀 Seção de Recursos Principais -->
<section class="bg-gray-800 py-16 text-white text-center px-8">
    <h2 class="text-4xl font-bold mb-8">✨ Por que escolher o TimeLove?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <!-- Recurso 1 -->
        <div class="bg-gray-700 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-bold mb-2">📸 Fotos e Vídeos</h3>
            <p class="text-gray-300">Armazene suas melhores lembranças em formato de fotos e vídeos com segurança.</p>
        </div>
        <!-- Recurso 2 -->
        <div class="bg-gray-700 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-bold mb-2">🔒 Privacidade Total</h3>
            <p class="text-gray-300">Somente você e quem você permitir terão acesso às cápsulas.</p>
        </div>
        <!-- Recurso 3 -->
        <div class="bg-gray-700 rounded-lg p-6 shadow-md">
            <h3 class="text-xl font-bold mb-2">🗓️ Acesso Agendado</h3>
            <p class="text-gray-300">Programe a abertura de cápsulas para datas especiais.</p>
        </div>
    </div>
</section>

<!-- ❤️ Seção de Depoimentos -->
<section class="bg-gray-900 py-16 text-white text-center px-8">
    <h2 class="text-4xl font-bold mb-8">💬 Depoimentos de Usuários</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <!-- Depoimento 1 -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-md">
            <p class="italic text-gray-300">"TimeLove me ajudou a preservar memórias incríveis do meu aniversário de
                casamento!"</p>
            <h4 class="font-bold mt-4">— Ana Silva</h4>
        </div>
        <!-- Depoimento 2 -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-md">
            <p class="italic text-gray-300">"Com o TimeLove consigo fazer stories que duram pra sempre!"</p>
            <h4 class="font-bold mt-4">— Lucas Oliveira</h4>
        </div>
        <!-- Depoimento 3 -->
        <div class="bg-gray-800 rounded-lg p-6 shadow-md">
            <p class="italic text-gray-300">"A experiência de compartilhar cápsulas com meus amigos foi incrível!"</p>
            <h4 class="font-bold mt-4">— Beatriz Costa</h4>
        </div>
    </div>
</section>

<!-- 📣 Call to Action Final -->
<section class="bg-rose-500 py-12 text-white text-center px-8">
    <h2 class="text-3xl font-bold mb-4">Pronto para Eternizar Seus Momentos?</h2>
    <p class="text-lg mb-6">Comece agora mesmo e crie sua primeira cápsula do tempo.</p>
    <a href="{{ route('register') }}"
        class="inline-block bg-white text-rose-500 font-bold py-3 px-6 rounded-lg shadow-md hover:bg-gray-200 transition duration-300">
        Cadastre-se Gratuitamente
    </a>
</section>

@endsection