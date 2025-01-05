@extends('layouts.guest-layout')

@section('header')
<div class="flex justify-between items-center px-8 py-4 bg-gradient-to-r from-gray-800 to-gray-900 shadow-md">
    <!-- Logo -->
    <div class="text-white text-2xl font-bold flex items-center gap-2">
        <img src="{{ asset('TimeLove.jpg') }}" alt="Logo"
            class="w-18 h-16 rounded-lg border-2 border-transparent hover:border-rose-500 transition-all duration-300 shadow-md object-cover">
    </div>

    <!-- Botão de Logout -->
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button class="rounded-full bg-rose-500 hover:bg-rose-600 text-white py-2 px-6 shadow-md transition">
            Sair
        </button>
    </form>
</div>
@endsection

@section('content')
<!-- Conteúdo principal com espaçamento uniforme -->
<div class="min-h-screen bg-gray-900 text-white px-6 md:px-12 py-6 md:py-12 space-y-12">

    <!-- Boas-Vindas -->
    <section class="text-center fade-in">
        @php
            $gender = auth()->user()->gender ?? 'default';
            $welcomeMessage = match ($gender) {
                'male' => 'Bem-vindo',
                'female' => 'Bem-vinda',
                default => 'Bem-vindo(a)'
            };
        @endphp

        <h1 class="text-4xl md:text-5xl font-bold mb-4">
            🎉 {{ $welcomeMessage }}, {{ auth()->user()->name }}!
        </h1>
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
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($recentStories as $story)
                    <div class="bg-gray-700 rounded-lg shadow-md overflow-hidden">
                        @if($story->media_type === 'image')
                            <img src="{{ asset('storage/' . $story->media_path) }}" alt="Story" class="w-full h-48 object-cover">
                        @elseif($story->media_type === 'video')
                            <video controls class="w-full h-48 object-cover">
                                <source src="{{ asset('storage/' . $story->media_path) }}" type="video/mp4">
                            </video>
                        @endif
                        <div class="p-4 text-center">
                            <p class="text-sm text-gray-300">{{ $story->description ?? 'Story' }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Ações Adicionais -->
    <section class="text-center fade-in">
        <h2 class="text-2xl md:text-3xl font-bold mb-6">⚙️ O que mais você pode fazer?</h2>
        <div class="flex justify-center gap-4 flex-wrap">
            <a href="{{ route('profile.edit') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition">
                🛠️ Editar Perfil
            </a>
            <a href="{{ route('landing') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition">
                🏠 Página Inicial
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