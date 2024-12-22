@extends('layouts.criador-layout')

@section('content')
<div class="container mx-auto px-4 py-6 text-white">
    <h1 class="text-3xl font-bold mb-4">Editar Cápsula</h1>

    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('capsules.update', $capsule->id) }}"
        class="bg-slate-900 p-6 rounded shadow-lg">
        @csrf
        @method('PUT') <!-- Importante para enviar PUT/PATCH -->

        <div class="mb-4">
            <label for="name" class="block text-sm text-gray-300 mb-1">Nome da Cápsula</label>
            <input type="text" id="name" name="name" class="w-full px-4 py-2 rounded bg-slate-800 text-white"
                value="{{ old('name', $capsule->name) }}" required>
        </div>

        <div class="mb-4">
            <label for="theme" class="block text-sm text-gray-300 mb-1">Tema da Cápsula</label>
            <input type="text" id="theme" name="theme" class="w-full px-4 py-2 rounded bg-slate-800 text-white"
                value="{{ old('theme', $capsule->theme) }}" required>
        </div>

        <button type="submit" class="px-4 py-2 bg-rose-600 text-white rounded hover:bg-rose-700 transition">
            Atualizar Cápsula
        </button>
    </form>
</div>
@endsection