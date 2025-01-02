@extends('layouts.guest-layout')

@section('header')
<div class="flex justify-between m-8">
    <div class="fade-out text-white text-2xl font-bold">
        TimeLove
    </div>
    <div class="fade-out text-black">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="rounded-full bg-white py-4 px-8 mx-4" type="submit">Sair</button>
        </form>
    </div>
</div>
@endsection

@section('content')
<div class="min-h-screen flex flex-col bg-gray-900 text-white">
    <!-- Boas-Vindas -->
    <section class="text-center py-8 fade-in">
        <h1 class="text-3xl font-bold mb-2">🎉 Bem-vindo(a), {{ auth()->user()->name }}!</h1>
        <p class="text-gray-300">Aqui estão as cápsulas do tempo compartilhadas com você.</p>
    </section>

    <!-- Cápsulas Compartilhadas -->
    <h2 class="text-xl font-bold mb-4 fade-in">📦 Cápsulas Compartilhadas</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 fade-in">
        @forelse ($sharedCapsules as $capsule)
            <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-white">{{ $capsule->name }}</h3>
                <p class="text-gray-400">Tema: {{ $capsule->theme }}</p>
                <p class="text-gray-400">Criador: {{ $capsule->user->name }}</p>
                <a href="{{ route('capsules.show', $capsule->id) }}" class="text-blue-400 hover:text-blue-500">
                    🔗 Ver Detalhes
                </a>
            </div>
        @empty
            <p class="text-gray-300 fade-in">Nenhuma cápsula compartilhada disponível.</p>
        @endforelse
    </div>

    <!-- Stories Recentes -->
    <section class="py-8 px-4">
        <h2 class="text-2xl font-bold mb-4 text-center fade-out">📸 Stories Recentes</h2>

        @if($recentStories->isEmpty())
            <p class="text-center text-gray-400 fade-out">Nenhuma história recente disponível.</p>
        @else
            <div class="flex gap-4 overflow-x-auto px-4 fade-in">
                @foreach($recentStories as $story)
                    <div class="w-32 h-32 bg-gray-800 rounded-lg flex items-center justify-center text-white">
                        @if($story->media_type === 'image')
                            <img src="{{ asset('storage/' . $story->media_path) }}" alt="Story"
                                class="w-full h-full object-cover rounded-lg">
                        @elseif($story->media_type === 'video')
                            <video controls class="w-full h-full object-cover rounded-lg">
                                <source src="{{ asset('storage/' . $story->media_path) }}" type="video/mp4">
                            </video>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <!-- Ações Adicionais -->
    <section class="py-8 px-4 text-center">
        <h2 class="text-2xl font-bold mb-4">⚙️ O que mais você pode fazer?</h2>
        <div class="flex justify-center gap-4">
            <a href="{{ route('profile.edit') }}"
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition">
                🛠️ Editar Perfil
            </a>
        </div>
    </section>
</div>

<script>
    // Script de Fade-in ao rolar a página
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

        window.addEventListener('scroll', handleScroll);
        handleScroll();
    });
</script>
@endsection