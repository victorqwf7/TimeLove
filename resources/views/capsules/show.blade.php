@extends('layouts.criador-layout')

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

<div class="container mx-auto px-4 py-6 text-white fade-in">
    <!-- Título da página -->
    <h1 class="text-3xl font-bold fade-in mb-6" style="--delay: 0.2s">
        Detalhes da Cápsula
    </h1>
    @if(auth()->user()->id === $capsule->user_id)
        <p class="text-green-500">Você é o criador desta cápsula.</p>
    @else
        <p class="text-blue-500">Você é um convidado com acesso a esta cápsula.</p>
    @endif

    <!-- Mensagens de sucesso ou erro (opcional) -->
    @if(session('success'))
        <div class="bg-green-600 text-white p-4 rounded mb-4 fade-in flex items-center justify-between"
            style="--delay: 0.3s">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-white text-xl font-bold">
                &times;
            </button>
        </div>
    @endif
    @if(session('error'))
        <div class="bg-red-600 text-white p-4 rounded mb-4 fade-in flex items-center justify-between" style="--delay: 0.3s">
            <span>{{ session('error') }}</span>
            <button onclick="this.parentElement.style.display='none'" class="text-white text-xl font-bold">
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

        <!-- Botões de Ação -->
        <div class="mt-4 flex flex-col sm:flex-row gap-4 fade-in" style="--delay: 0.6s">
            <!-- Botão para Abrir o Player de Stories -->
            @if($stories->isNotEmpty())
                <a href="{{ route('stories.player', $capsule->id) }}"
                    class="px-4 py-2 bg-purple-600 text-white rounded hover:bg-purple-700 transition duration-200 text-center">
                    Ver Stories
                </a>
            @else
                <p class="text-gray-400 italic">Nenhum story disponível para esta cápsula.</p>
            @endif

            <!-- Botão de Editar -->
            <a href="{{ route('capsules.edit', $capsule->id) }}"
                class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition duration-200 text-center">
                Editar Cápsula
            </a>

            <!-- Formulário para Excluir -->
            <form method="POST" action="{{ route('capsules.destroy', $capsule->id) }}"
                onsubmit="return confirm('Tem certeza que deseja excluir esta cápsula?')" class="flex items-center">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition duration-200 text-center">
                    Excluir
                </button>
            </form>
        </div>
        <!-- Campos para compartilhar cápsula -->
        @if (auth()->user()->id === $capsule->user_id)
            <h2 class="text-xl font-bold mt-6">Compartilhar Cápsula</h2>
            <form method="POST" action="{{ route('capsules.share', $capsule->id) }}" class="mt-4">
                @csrf
                <label for="email" class="block text-gray-300 mb-2">E-mail do Convidado:</label>
                <input type="email" id="email" name="email" required placeholder="Digite o e-mail do convidado"
                    class="w-full px-4 py-2 rounded-lg bg-gray-800 text-white focus:ring-2 focus:ring-blue-500">
                <button type="submit" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Compartilhar
                </button>
            </form>
        @endif

    </div>

    <!-- FORMULÁRIO DE ADICIONAR NOVO STORY -->
    <form method="POST" action="{{ route('stories.store', $capsule->id) }}" enctype="multipart/form-data"
        class="bg-slate-900 p-6 mt-6 rounded-lg shadow-lg fade-in" style="--delay: 0.5s" id="add-story-form">
        @csrf
        <h2 class="text-xl font-semibold mb-6">Adicionar Novo Story</h2>

        <!-- Arquivo de Mídia -->
        <div class="mb-4">
            <label for="media_file" class="block text-gray-300 mb-2">Selecione a Foto ou Vídeo</label>
            <input type="file" id="media_file" name="media_file" accept="image/*,video/*" required class="w-full text-gray-300 bg-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500
                       @error('media_file') border-2 border-red-500 @enderror">
            @error('media_file')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Duração -->
        <div class="mb-4" id="duration-container">
            <label for="duration" class="block text-gray-300 mb-2">Duração (segundos)</label>
            <input type="number" id="duration" name="duration" min="1" max="30" value="{{ old('duration', 5) }}" class="w-full text-gray-300 bg-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500
                       @error('duration') border-2 border-red-500 @enderror">
            @error('duration')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Descrição Opcional -->
        <div class="mb-4">
            <label for="description" class="block text-gray-300 mb-2">Descrição (Opcional)</label>
            <textarea id="description" name="description"
                class="w-full text-gray-300 bg-gray-700 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Adicione uma descrição curta para este story"></textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition duration-200">
            Criar Story
        </button>
    </form>

    <!-- LISTAGEM DE STORIES -->
    <h2 class="text-2xl font-bold mt-8 mb-4 fade-in" style="--delay: 0.7s">Meus Stories</h2>

    @if($stories->isEmpty())
        <p class="text-gray-300">Nenhuma story adicionada ainda.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in">
            @foreach($stories as $story)
                <div class="bg-slate-800 p-4 rounded-lg shadow-md relative">
                    @if($story->media_type === 'image')
                        <img src="{{ asset('storage/' . $story->media_path) }}" alt="Story"
                            class="w-full h-48 object-cover rounded-lg mb-4">
                    @elseif($story->media_type === 'video')
                        <video controls class="w-full h-48 object-cover rounded-lg mb-4">
                            <source src="{{ asset('storage/' . $story->media_path) }}" type="video/mp4">
                        </video>
                    @endif

                    <div class="text-gray-400 text-sm mb-4">
                        <p><strong>Duração:</strong> {{ $story->duration }}s</p>
                        <p><strong>Criado em:</strong> {{ $story->created_at->format('d/m/Y H:i') }}</p>
                        @if($story->description)
                            <p><strong>Descrição:</strong> {{ $story->description }}</p>
                        @endif
                    </div>

                    <form method="POST"
                        action="{{ route('stories.destroy', ['capsule' => $capsule->id, 'story' => $story->id]) }}"
                        onsubmit="return confirm('Tem certeza que deseja excluir este story?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="absolute bottom-4 right-2 px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition">
                            Excluir
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif


    @if (auth()->user()->id === $capsule->user_id)
        <!-- Link para Criadores -->
        <a href="{{ route('capsules.index') }}" class="underline text-rose-500 hover:text-rose-700 transition my-8">
            Voltar à Listagem
        </a>
    @else
        <!-- Link para Convidados -->
        <a href="{{ route('guest-home') }}" class="underline text-rose-500 hover:text-rose-700 transition my-8">
                Voltar para o início
            </a>
    @endif
</div>

<!-- Script para Manipular o Formulário -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const mediaFileInput = document.getElementById('media_file');
        const durationContainer = document.getElementById('duration-container');
        const durationInput = document.getElementById('duration');

        mediaFileInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const fileType = file.type;
                if (fileType.startsWith('image/')) {
                    // Se for imagem
                    durationInput.value = 5; // Define duração padrão (5 segundos)
                    durationInput.disabled = true; // Desabilita o campo
                    durationContainer.classList.add('opacity-50'); // Indica que está desabilitado
                } else if (fileType.startsWith('video/')) {
                    // Se for vídeo
                    durationInput.value = ''; // Limpa o campo
                    durationInput.disabled = false; // Habilita o campo
                    durationContainer.classList.remove('opacity-50'); // Remove indicação de desabilitado
                } else {
                    // Tipo de arquivo não suportado
                    alert('Por favor, selecione um arquivo de imagem ou vídeo válido.');
                    this.value = ''; // Limpa a seleção
                    durationInput.value = '';
                    durationInput.disabled = false;
                    durationContainer.classList.remove('opacity-50');
                }
            } else {
                // Nenhum arquivo selecionado
                durationInput.value = '';
                durationInput.disabled = false;
                durationContainer.classList.remove('opacity-50');
            }
        });
    });
</script>
@endsection