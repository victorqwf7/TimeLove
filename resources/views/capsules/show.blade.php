@extends('layouts.criador-layout')

@section('content')
<div class="container mx-auto px-4 py-6 text-white">
    <!-- Título da página -->
    <h1 class="text-3xl font-bold fade-in" style="--delay: 0.2s">
        Detalhes da Cápsula
    </h1>

    <!-- Mensagem de sucesso ou erro (opcional) -->
    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded mb-4 fade-in flex items-center justify-between"
            style="--delay: 0.3s">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-white">
                &times;
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-600 text-white p-4 rounded mb-4 fade-in flex items-center justify-between" style="--delay: 0.3s">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-white">
                &times;
            </button>
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
        <div class="mt-4 flex flex-col sm:flex-row gap-4 fade-in" style="--delay: 0.6s">
            <!-- Botão para Abrir o Player de Stories -->
            <a href="{{ route('stories.player', $capsule->id) }}"
                class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition duration-200 text-center">
                Ver Stories
            </a>
        </div>
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


    <!-- STORIES -->
    <form method="POST" action="{{ route('stories.store', $capsule->id) }}" enctype="multipart/form-data"
        class="bg-slate-900 p-6 mt-6 rounded-lg shadow-lg fade-in" style="--delay: 0.5s">
        @csrf
        <h2 class="text-xl font-semibold mb-4">Adicionar Novo Story</h2>

        <div class="mb-4">
            <label for="media_file" class="block text-gray-300 mb-2">Selecione a Foto ou Vídeo</label>
            <input type="file" id="media_file" name="media_file" accept="image/*,video/*" required class="w-full text-gray-300 bg-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500
                   @error('media_file') border-2 border-red-500 @enderror">
            @error('media_file')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-4">
            <label for="duration" class="block text-gray-300 mb-2">Duração (segundos)</label>
            <input type="number" id="duration" name="duration" min="1" max="30" value="{{ old('duration', 5) }}" class="w-full text-gray-300 bg-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500
                   @error('duration') border-2 border-red-500 @enderror">
            @error('duration')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition duration-200">
            Criar Story
        </button>
    </form>


    <h2 class="text-2xl font-bold mt-6 mb-4 fade-in" style="--delay: 0.7s">Meus Stories</h2>

    @if($stories->isEmpty())
        <p class="text-gray-300">Nenhuma story adicionada ainda.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($stories as $story)
                <div class="bg-slate-800 p-4 rounded-lg shadow-md">
                    @if($story->media_type === 'image')
                        <img src="{{ asset('storage/' . $story->media_path) }}" alt="Story Image"
                            class="w-full h-48 object-cover rounded-lg mb-4">
                    @elseif($story->media_type === 'video')
                        <video controls class="w-full h-48 object-cover rounded-lg mb-4">
                            <source src="{{ asset('storage/' . $story->media_path) }}" type="video/mp4">
                            Seu navegador não suporta vídeo HTML5.
                        </video>
                    @endif
                    <div class="text-gray-400 text-sm">
                        <p><strong>Duração:</strong> {{ $story->duration }}s</p>
                        <p><strong>Criado em:</strong> {{ $story->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    @endif


    <!-- Link para voltar à listagem ou outra página -->
    <div class="mt-6 fade-in" style="--delay: 0.8s">
        <a href="{{ route('capsules.index') }}" class="underline text-rose-500 hover:text-rose-700 transition">
            Voltar à Listagem
        </a>
    </div>
</div>
@endsection