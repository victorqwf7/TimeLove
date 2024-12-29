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

<!-- Boas-Vindas -->
<section class="text-center py-8 text-white bg-gray-900 my-8">
    <h1 class="text-3xl font-bold mb-2">🎉 Bem-vindo(a), {{ auth()->user()->name }}!</h1>
    <p class="text-gray-300">Explore as cápsulas do tempo compartilhadas com você.</p>
</section>

<!-- Cápsulas Compartilhadas -->
<section class="py-8 bg-gray-800 mx-8">
    <h2 class="text-2xl font-bold text-white text-center mb-4">📦 Cápsulas Compartilhadas</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 px-4">
        @forelse($sharedCapsules as $capsule)
            <div class="bg-gray-700 p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold text-white">{{ $capsule->name }}</h3>
                <p class="text-gray-400">Tema: {{ $capsule->theme }}</p>
                <p class="text-gray-400">Criador: {{ $capsule->user->name }}</p>
                <a href="{{ route('capsules.show', $capsule->id) }}" class="text-blue-400 hover:text-blue-500">🔗 Ver
                    Detalhes</a>
            </div>
        @empty
            <p class="text-gray-300 text-center col-span-3">Nenhuma cápsula compartilhada ainda.</p>
        @endforelse
    </div>
</section>

<!-- Stories Recentes -->
<section class="py-8 bg-gray-900 m-8">
    <h2 class="text-2xl font-bold text-white text-center mb-4">📸 Stories Recentes</h2>
    <div class="flex gap-4 overflow-x-auto px-4">
        @forelse($recentStories as $story)
            <div class="w-32 h-32 bg-gray-700 rounded-lg flex items-center justify-center text-white">
                @if($story->media_type === 'image')
                    <img src="{{ asset('storage/' . $story->media_path) }}" class="w-full h-full object-cover rounded-lg">
                @elseif($story->media_type === 'video')
                    <video src="{{ asset('storage/' . $story->media_path) }}" class="w-full h-full object-cover rounded-lg"
                        autoplay muted></video>
                @endif
            </div>
        @empty
            <p class="text-gray-300">Nenhum story recente.</p>
        @endforelse
    </div>
</section>

<!-- Configurações (Opcional) -->
<section class="py-8 bg-gray-900 m-8">
    <h2 class="text-2xl font-bold text-white text-center mb-4">⚙️ Configurações</h2>
    <p class="text-center text-gray-300">Gerencie suas preferências de notificações e perfil.</p>
    <div class="text-center mt-4">
        <a href="#" class="text-blue-400 hover:text-blue-500">🔧 Editar Perfil</a>
    </div>
</section>

@endsection