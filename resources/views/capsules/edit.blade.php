@extends('layouts.criador-layout')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-900 px-4 py-8">
    <div class="w-full max-w-2xl bg-gray-800 p-8 rounded-xl shadow-2xl fade-in" style="--delay: 0.2s">

        <!-- Título -->
        <h1 class="text-4xl font-bold text-white mb-6 text-center">✏️ Editar Cápsula</h1>

        <!-- Alerta de Sucesso -->
        @if(session('success'))
            <div class="bg-green-600 text-white p-4 rounded-md mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Formulário -->
        <form method="POST" action="{{ route('capsules.update', $capsule->id) }}" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Nome da Cápsula -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-300 mb-2">📛 Nome da Cápsula</label>
                <input type="text" id="name" name="name"
                    class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-rose-500 focus:outline-none transition"
                    value="{{ old('name', $capsule->name) }}" required>
            </div>

            <!-- Tema da Cápsula -->
            <div>
                <label for="theme" class="block text-sm font-medium text-gray-300 mb-2">🎨 Tema da Cápsula</label>
                <input type="text" id="theme" name="theme"
                    class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-rose-500 focus:outline-none transition"
                    value="{{ old('theme', $capsule->theme) }}" required>
            </div>

            <!-- Botões de Ação -->
            <div class="flex items-center justify-between mt-6">
                <a href="{{ route('capsules.index') }}"
                    class="px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition duration-200">
                    ⬅️ Voltar
                </a>
                <button type="submit"
                    class="px-6 py-3 bg-rose-600 text-white font-semibold rounded-lg hover:bg-rose-700 transition duration-300 shadow-md">
                    💾 Atualizar Cápsula
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Script Fade-in
    document.addEventListener('DOMContentLoaded', function () {
        const items = document.querySelectorAll('.fade-in');

        items.forEach((item) => {
            item.style.opacity = 0;
            item.style.transform = 'translateY(20px)';
            setTimeout(() => {
                item.style.opacity = 1;
                item.style.transform = 'translateY(0)';
                item.style.transition = 'opacity 0.5s ease-out, transform 0.5s ease-out';
            }, 200);
        });
    });
</script>
@endsection