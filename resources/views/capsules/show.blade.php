@extends('layouts.criador-layout')

@section('content')
<div class="container mx-auto px-4 py-6 text-white">
    <!-- Título da página -->
    <h1 class="text-3xl font-bold fade-in" style="--delay: 0.2s">
        Detalhes da Cápsula
    </h1>

    <!-- Mensagem de sucesso ou erro (opcional) -->
    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded mb-4 fade-in" style="--delay: 0.3s">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-600 text-white p-4 rounded mb-4 fade-in" style="--delay: 0.3s">
            {{ session('error') }}
        </div>
    @endif

    <!-- Cartão com informações da cápsula -->
    <div class="bg-slate-900 p-6 mt-4 rounded-lg shadow-lg fade-in" style="--delay: 0.4s">
        <h2 class="text-2xl font-semibold mb-4">
            {{ $capsule->name }}
        </h2>
        <p class="text-gray-400 mb-2">
            <strong>Tema:</strong> {{ $capsule->theme }}
        </p>
        <p class="text-gray-400 mb-2">
            <strong>Data de Criação:</strong>
            {{ $capsule->created_at->format('d/m/Y') }}
        </p>
        <!-- Se quiser adicionar mais informações do model, insira aqui -->

        <hr class="border-gray-600 my-4">

        <div class="mt-4 flex flex-col sm:flex-row gap-4 fade-in" style="--delay: 0.6s">
            <!-- Botão de Adicionar Fotos (exemplo) -->
            <a href="#"
                class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200 text-center">
                Adicionar Fotos
            </a>

            <!-- Botão de Editar -->
            <a href="{{ route('capsules.edit', $capsule->id) }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition duration-200 text-center">
                Editar
            </a>

            <!-- Formulário p/ Excluir -->
            <form method="POST" action="{{ route('capsules.destroy', $capsule->id) }}"
                onsubmit="return confirm('Tem certeza que deseja excluir esta cápsula?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition duration-200 text-center">
                    Excluir
                </button>
            </form>
        </div>
    </div>
    

    <!-- Link para voltar à listagem ou outra página -->
    <div class="mt-6 fade-in" style="--delay: 0.8s">
        <a href="{{ route('capsules.index') }}" class="underline text-rose-500 hover:text-rose-700 transition">
            Voltar à Listagem
        </a>
    </div>
</div>
@endsection