@extends('layouts.criador-layout')

@section('content')
<div class="container mx-auto py-6 px-4 text-white">
    <h1 class="text-3xl font-bold mb-6 fade-in" style="--delay: 0.2s">
        Minhas Cápsulas
    </h1>

    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded mb-4 fade-in" style="--delay: 0.4s">
            {{ session('success') }}
        </div>
    @endif

    @if($capsules->isEmpty())
        <p class="fade-in text-gray-300" style="--delay: 0.6s">
            Você não tem nenhuma cápsula criada.
        </p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in" style="--delay: 0.6s">
            @foreach($capsules as $capsule)
                <div class="bg-slate-900 rounded-lg shadow-lg p-6 flex flex-col">
                    <h2 class="text-xl font-semibold mb-2">
                        {{ $capsule->name }}
                    </h2>
                    <p class="text-gray-400 mb-4">
                        Tema: <span class="capitalize">{{ $capsule->theme }}</span>
                    </p>
                    <a href="{{ route('capsules.show', $capsule->id) }}"
                        class="mt-auto px-4 py-2 bg-rose-600 text-white rounded hover:bg-rose-700 transition duration-200">
                        Ver Detalhes
                    </a>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-4 text-white text-center fade-in" style="--delay: 4s">
        <a href="{{ route('criador-home') }}"
            class="inline-block py-2 underline text-rose-500 hover:text-rose-700 transition">
            Criar nova Cápsula do tempo
        </a>
    </div>
</div>
@endsection