@extends('layouts.guest-layout')

@section('content')

<style>
    details[open] summary {
        color: #f87171;
        /* Muda a cor da pergunta aberta */
    }

    details {
        transition: all 0.3s ease-in-out;
    }
</style>

<!-- 🌟 Seção Hero -->
<section class="w-full h-screen bg-gray-900 text-white flex items-center justify-center px-4 md:px-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center w-full max-w-6xl animate-fade-in">
        <!-- Coluna Esquerda -->
        <div class="space-y-6">
            <h1 class="text-5xl md:text-6xl font-extrabold leading-tight mt-10">
                Eternize seus Momentos com o <span class="text-rose-500">TimeLove ❤️</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-300">
                Crie cápsulas do tempo digitais, adicione fotos, vídeos e mensagens para guardar suas memórias mais
                especiais.
            </p>
            <div class="flex gap-4">
                <a href="{{ route('register') }}"
                    class="bg-rose-500 hover:bg-rose-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300">
                    Comece Agora
                </a>
                <a href="#features"
                    class="bg-gray-700 hover:bg-gray-800 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300">
                    Saiba Mais
                </a>
            </div>
        </div>

        <!-- Coluna Direita -->
        <div class="flex justify-center mb-20">
            <div
                class="w-full max-w-md h-96 bg-gray-800 rounded-lg shadow-lg overflow-hidden relative animate-slide-in-right">
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
<section id="features" class="bg-gray-800 py-16 text-white text-center px-4 md:px-8">
    <h2 class="text-4xl font-bold mb-8">✨ Por que escolher o TimeLove?</h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
        <!-- Recurso 1 -->
        <div class="bg-gray-700 rounded-lg p-6 shadow-md hover:shadow-xl transition duration-300 hover:scale-105">
            <h3 class="text-xl font-bold mb-2">📸 Fotos e Vídeos</h3>
            <p class="text-gray-300">Armazene suas melhores lembranças em formato de fotos e vídeos com segurança.</p>
        </div>
        <!-- Recurso 2 -->
        <div class="bg-gray-700 rounded-lg p-6 shadow-md hover:shadow-xl transition duration-300 hover:scale-105">
            <h3 class="text-xl font-bold mb-2">🔒 Privacidade Total</h3>
            <p class="text-gray-300">Somente você e quem você permitir terão acesso às cápsulas.</p>
        </div>
        <!-- Recurso 3 -->
        <div class="bg-gray-700 rounded-lg p-6 shadow-md hover:shadow-xl transition duration-300 hover:scale-105">
            <h3 class="text-xl font-bold mb-2">🗓️ Acesso Agendado</h3>
            <p class="text-gray-300">Programe a abertura de cápsulas para datas especiais.</p>
        </div>
    </div>
</section>

<!-- ❓ Seção de Perguntas Frequentes (FAQ) -->
<section id="faq" class="bg-gray-800 py-16 text-white text-center px-4 md:px-8">
    <h2 class="text-4xl font-bold mb-8">❓ Perguntas Frequentes</h2>
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
        <details class="bg-gray-700 p-4 rounded-lg shadow-md hover:bg-gray-600 transition">
            <summary class="font-semibold cursor-pointer text-lg">📦 Como funcionam as cápsulas do tempo?</summary>
            <p class="mt-2 text-gray-300">Você pode criar cápsulas digitais, adicionar fotos, vídeos e agendar aberturas
                especiais.</p>
        </details>
        <details class="bg-gray-700 p-4 rounded-lg shadow-md hover:bg-gray-600 transition">
            <summary class="font-semibold cursor-pointer text-lg">🔒 Meus dados são seguros?</summary>
            <p class="mt-2 text-gray-300">Sim! Utilizamos criptografia avançada para proteger todas as suas informações.
            </p>
        </details>
        <details class="bg-gray-700 p-4 rounded-lg shadow-md hover:bg-gray-600 transition">
            <summary class="font-semibold cursor-pointer text-lg">📲 Posso acessar pelo celular?</summary>
            <p class="mt-2 text-gray-300">Claro! O TimeLove é otimizado para dispositivos móveis.</p>
        </details>
        <details class="bg-gray-700 p-4 rounded-lg shadow-md hover:bg-gray-600 transition">
            <summary class="font-semibold cursor-pointer text-lg">🆓 O TimeLove é gratuito?</summary>
            <p class="mt-2 text-gray-300">Sim! Há uma versão gratuita com todas as funcionalidades principais
                disponíveis.</p>
        </details>
    </div>
</section>

<!-- 📣 Call to Action Final -->
<section class="bg-rose-500 py-12 text-white text-center px-4 md:px-8">
    <h2 class="text-3xl font-bold mb-4">Pronto para Eternizar Seus Momentos?</h2>
    <p class="text-lg mb-6">Comece agora mesmo e crie sua primeira cápsula do tempo.</p>
    <a href="{{ route('register') }}"
        class="bg-white text-rose-500 font-bold py-3 px-6 rounded-lg shadow-md hover:bg-gray-200 transition">
        Cadastre-se Gratuitamente
    </a>
</section>



@endsection