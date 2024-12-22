@if(session('success'))
    <div class="bg-green-600 text-white p-4 rounded mb-4 fade-in" style="--delay: 0.1s">
        {{ session('success') }}
    </div>
@endif

@extends('layouts.guest-layout')

@section('header')
<div class="flex justify-between m-8">
    <div class="fade-out text-white">
        TimeLove
    </div>
    <div class="fade-out text-black">
        <form method="POST" action="{{route('logout')}}">
            @csrf
            <button class="rounded-full bg-white py-4 px-8 mx-4" type="submit">Sair</button>
        </form>
    </div>
</div>
@endsection

@section('content')

<section class="flex flex-col items-center mt-10 text-white">
    <!-- Título da página -->
    <h1 class="text-4xl font-bold mb-6 fade-in" style="--delay: 0.3s">Criar Cápsula do Tempo</h1>
    <p class="text-center mb-8 text-gray-300 fade-in" style="--delay: 0.8s">
        Crie um álbum temático e adicione fotos e vídeos para guardar memórias especiais.
    </p>

    <!-- Formulário para criar uma cápsula -->
    <form method="POST" action="{{ route('capsule.store') }}"
        class="w-full max-w-lg bg-slate-900 p-6 rounded-lg shadow-lg fade-in" style="--delay: 0.8s">
        @csrf
        <!-- Nome da cápsula -->
        <!-- Nome da cápsula -->
        <div class="mb-4">
            <label for="capsule-name" class="block text-sm font-medium text-gray-400 mb-1 fade-in" style="--delay: 1s">
                Nome da Cápsula
            </label>
            <input type="text" id="capsule-name" name="name"
                class="w-full px-4 py-2 rounded-lg bg-slate-800 text-white focus:ring-rose-500 focus:border-rose-500 fade-in"
                style="--delay: 1.2s" placeholder="Ex: Viagem a Paris">
        </div>

        <!-- Tema da cápsula (livre) -->
        <div class="mb-4">
            <label for="capsule-theme" class="block text-sm font-medium text-gray-400 mb-1 fade-in"
                style="--delay: 1.4s">
                Tema da Cápsula
            </label>
            <input type="text" id="capsule-theme" name="theme"
                class="w-full px-4 py-2 rounded-lg bg-slate-800 text-white focus:ring-rose-500 focus:border-rose-500 fade-in"
                style="--delay: 1.6s" placeholder="Ex: Aniversário de 2 anos de namoro">
        </div>

        <!-- Botão de criar -->
        <div class="flex justify-end fade-in" style="--delay: 1.8s">
            <button type="submit" class="px-6 py-2 bg-rose-600 text-white rounded-lg hover:bg-rose-700 transition">
                Criar Cápsula
            </button>
        </div>
    </form>
</section>

<!-- Link para a página inicial -->
<div class="mt-4 text-white text-center fade-in" style="--delay: 2s">
    <a href="{{ route('dashboard') }}" class="inline-block py-2 underline text-rose-500 hover:text-rose-700 transition">
        Ir para página inicial de dashboard
    </a>
</div>

<div class="mt-4 text-white text-center fade-in" style="--delay: 4s">
    <a href="{{ route('capsules.index') }}"
        class="inline-block py-2 underline text-rose-500 hover:text-rose-700 transition">
        Ir para minha capsulas
    </a>
</div>

@endsection



<script>
    // script fade ao rolar a página
    document.addEventListener('DOMContentLoaded', function () {
        const items = document.querySelectorAll('.scroll-fade-in');

        const handleScroll = () => {
            items.forEach((item) => {
                const rect = item.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    item.classList.add('show');
                }
            });
        };

        // Detecta o scroll na página
        window.addEventListener('scroll', handleScroll);

        // Verifica os itens já visíveis na carga inicial
        handleScroll();
    });
</script>