@extends('layouts.guest-layout')

@section('header')
<!-- Cabeçalho com espaçamento refinado -->
<div class="flex justify-between items-center px-8 py-4 bg-gray-800 shadow-md">
    <div class="text-2xl font-bold text-white">
        TimeLove ❤️
    </div>
    <div class="flex items-center gap-4">
        <a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-white transition">
            🧑 Meu Perfil
        </a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-md">
                Sair
            </button>
        </form>
    </div>
</div>
@endsection

@section('content')
<!-- Conteúdo principal com espaçamento uniforme -->
<div class="min-h-screen bg-gray-900 text-white px-6 md:px-12 py-6 md:py-12 space-y-12">

    <!-- Boas-Vindas -->
    <section class="text-center fade-in">
        <h1 class="text-4xl md:text-5xl font-bold mb-4">🎉 Bem-vindo(a), {{ auth()->user()->name }}!</h1>
        <p class="text-lg md:text-xl text-gray-300">
            Aqui estão as cápsulas do tempo compartilhadas com você.
        </p>
    </section>

    <!-- Cápsulas Compartilhadas -->
    <section>
        <h2 class="text-2xl md:text-3xl font-bold mb-6 text-center fade-in">📦 Cápsulas Compartilhadas</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in">
            @forelse ($sharedCapsules as $capsule)
                <div class="bg-gray-800 p-5 rounded-lg shadow-lg hover:shadow-xl transition transform hover:scale-105">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 bg-gray-700 rounded-full flex items-center justify-center">
                            📸
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-white">{{ $capsule->name }}</h3>
                            <p class="text-gray-400">Tema: {{ $capsule->theme }}</p>
                            <p class="text-gray-400">Criador: {{ $capsule->user->name }}</p>
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="{{ route('capsules.show', $capsule->id) }}"
                            class="text-blue-400 hover:text-blue-500 underline">
                            🔗 Ver Detalhes
                        </a>
                    </div>
                </div>
            @empty
                <p class="text-gray-300 text-center col-span-3">Nenhuma cápsula compartilhada disponível.</p>
            @endforelse
        </div>
    </section>

    <!-- Stories Recentes -->
    <section class="bg-gray-800 rounded-lg shadow-lg px-6 py-8 fade-in">
        <h2 class="text-2xl md:text-3xl font-bold mb-6 text-center">📸 Stories Recentes</h2>
        @if($recentStories->isEmpty())
            <p class="text-center text-gray-400">Nenhuma história recente disponível.</p>
        @else
            <!-- Container Responsivo -->
            <div class="grid grid-cols-1 md:flex md:gap-6 md:overflow-x-auto px-4 py-4 snap-x">
                @foreach($recentStories as $story)
                    <div
                        class="w-full md:w-48 md:h-48 bg-gray-700 rounded-lg shadow-md snap-center relative overflow-hidden mb-4 md:mb-0">
                        @if($story->media_type === 'image')
                            <img src="{{ asset('storage/' . $story->media_path) }}" alt="Story"
                                class="w-full h-64 md:h-full object-cover">
                        @elseif($story->media_type === 'video')
                            <video controls class="w-full h-64 md:h-full object-cover">
                                <source src="{{ asset('storage/' . $story->media_path) }}" type="video/mp4">
                            </video>
                        @endif
                        <div class="absolute bottom-0 left-0 w-full bg-black bg-opacity-50 text-white text-sm p-2">
                            {{ $story->description ?? 'Story' }}
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Ações Adicionais -->
    <section class="text-center fade-in">
        <h2 class="text-2xl md:text-3xl font-bold mb-6">⚙️ O que mais você pode fazer?</h2>
        <div class="flex justify-center gap-4">
            <a href="{{ route('profile.edit') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                🛠️ Editar Perfil
            </a>
            <a href="{{ route('landing') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                🏠 Ir para a Página Inicial
            </a>
        </div>
    </section>
</div>

<script>
    // Script de Fade-in ao rolar a página
    document.addEventListener('DOMContentLoaded', function () {
        const items = document.querySelectorAll('.fade-in');

        const handleScroll = () => {
            items.forEach((item) => {
                const rect = item.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    item.classList.add('show');
                }
            });
        };

        window.addEventListener('scroll', handleScroll);
        handleScroll();
    });
</script>
@endsection