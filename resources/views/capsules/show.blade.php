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
    <div class="bg-slate-800 p-8 mt-6 rounded-xl shadow-xl fade-in max-w-4xl mx-auto" style="--delay: 0.4s">
        <!-- Título e Informações da Cápsula -->
        <div class="mb-6 border-b border-gray-700 pb-4">
            <h2 class="text-3xl font-extrabold text-white mb-2">
                📦 {{ $capsule->name }}
            </h2>
            <p class="text-gray-400 mb-1">
                <strong>Tema:</strong> {{ $capsule->theme }}
            </p>
            <p class="text-gray-400 mb-1">
                <strong>Data de Criação:</strong> {{ $capsule->created_at->format('d/m/Y') }}
            </p>
        </div>

        <!-- Botões de Ação -->
        <div class="flex flex-col sm:flex-row gap-4 items-center justify-start mb-6 fade-in" style="--delay: 0.6s">
            <!-- Ver Stories -->
            @if($stories->isNotEmpty())
                <a href="{{ route('stories.player', $capsule->id) }}"
                    class="w-full sm:w-auto px-6 py-3 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition duration-300 text-center flex items-center gap-2">
                    📺 Ver Stories
                </a>
            @else
                <p class="text-gray-400 italic">Nenhum story disponível para esta cápsula.</p>
            @endif

            <!-- Editar Cápsula -->
            <a href="{{ route('capsules.edit', $capsule->id) }}"
                class="w-full sm:w-auto px-6 py-3 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition duration-300 text-center flex items-center gap-2">
                ✏️ Editar Cápsula
            </a>

            <!-- Excluir Cápsula -->
            <form method="POST" action="{{ route('capsules.destroy', $capsule->id) }}"
                onsubmit="return confirm('Tem certeza que deseja excluir esta cápsula?')">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full sm:w-auto px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-300 text-center flex items-center gap-2">
                    🗑️ Excluir
                </button>
            </form>
        </div>

        <!-- Compartilhar Cápsula -->
        @if (auth()->user()->id === $capsule->user_id)
            <div class="bg-gray-900 rounded-lg p-6 mt-6 shadow-md">
                <h3 class="text-xl font-semibold text-white mb-4">🔗 Compartilhar Cápsula</h3>
                <form method="POST" action="{{ route('capsules.share', $capsule->id) }}">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-4">
                        <div class="flex-grow">
                            <label for="email" class="block text-gray-400 mb-2">📧 E-mail do Convidado:</label>
                            <input type="email" id="email" name="email" required placeholder="Digite o e-mail do convidado"
                                class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500">
                        </div>
                        <button type="submit"
                            class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition duration-300 flex items-center gap-2 justify-center">
                            🚀 Compartilhar
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <!-- FORMULÁRIO DE ADICIONAR NOVO STORY -->
    <form method="POST" action="{{ route('stories.store', $capsule->id) }}" enctype="multipart/form-data"
        class="bg-gray-800 p-8 mt-6 rounded-xl shadow-2xl fade-in max-w-4xl mx-auto" id="add-story-form">
        @csrf

        <h2 class="text-2xl font-bold text-center mb-6 text-white">✨ Adicionar Novo Story</h2>

        <!-- Arquivo de Mídia -->
        <div class="mb-6">
            <label for="media_file" class="block text-gray-300 mb-2 font-medium">📂 Selecione a Foto ou Vídeo (vídeos
                nao funcionando)</label>
            <div class="relative">
                <input type="file" id="media_file" name="media_file" accept="image/*,video/*" required
                    class="w-full text-gray-300 bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('media_file') border-2 border-red-500 @enderror">
                <span class="absolute right-3 top-3 text-gray-400">
                    📸
                </span>
            </div>
            @error('media_file')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Duração -->
        <div class="mb-6">
            <label for="duration" class="block text-gray-300 mb-2 font-medium">⏱️ Duração (segundos)</label>
            <div class="relative">
                <input type="number" id="duration" name="duration" min="1" max="30" value="{{ old('duration', 5) }}"
                    class="w-full text-gray-300 bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 @error('duration') border-2 border-red-500 @enderror">
                <span class="absolute right-3 top-3 text-gray-400">
                    🕒
                </span>
            </div>
            <p id="duration-info" class="text-gray-400 text-sm mt-1 hidden">
                ⚠️ A duração não pode ser alterada para fotos.
            </p>
            @error('duration')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Descrição Opcional -->
        <div class="mb-6">
            <label for="description" class="block text-gray-300 mb-2 font-medium">📝 Descrição (Opcional)</label>
            <textarea id="description" name="description"
                class="w-full text-gray-300 bg-gray-700 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Adicione uma descrição curta para este story"></textarea>
            @error('description')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Botão de Envio -->
        <button type="submit"
            class="w-full bg-gradient-to-r from-blue-500 to-blue-700 text-white py-3 rounded-lg font-bold hover:from-blue-600 hover:to-blue-800 transition duration-300 transform hover:scale-105">
            🚀 Criar Story
        </button>
    </form>

    <!-- LISTAGEM DE STORIES -->
    <h2 class="text-3xl font-bold mt-8 mb-6 text-center fade-in" style="--delay: 0.7s">📸 Meus Stories</h2>

    @if($stories->isEmpty())
        <p class="text-gray-400 text-center mb-8 fade-in">Nenhuma story adicionada ainda.</p>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 fade-in">
            @foreach($stories as $story)
                <div
                    class="bg-gray-800 rounded-lg shadow-lg overflow-hidden hover:shadow-2xl transition-transform transform hover:scale-105 relative group">
                    <!-- Mídia (Imagem ou Vídeo) -->
                    <div class="h-48 overflow-hidden">
                        @if($story->media_type === 'image')
                            <img src="{{ asset('storage/' . $story->media_path) }}" alt="Story"
                                class="w-full h-full object-cover group-hover:brightness-75 transition">
                        @elseif($story->media_type === 'video')
                            <video controls class="w-full h-full object-cover group-hover:brightness-75 transition">
                                <source src="{{ asset('storage/' . $story->media_path) }}" type="video/mp4">
                            </video>
                        @endif
                    </div>

                    <!-- Informações do Story -->
                    <div class="p-4">
                        <p class="text-gray-300 text-sm"><strong>Duração:</strong> {{ $story->duration }}s</p>
                        <p class="text-gray-400 text-sm"><strong>Criado em:</strong>
                            {{ $story->created_at->format('d/m/Y H:i') }}</p>
                        @if($story->description)
                            <p class="text-gray-300 text-sm mt-2"><strong>Descrição:</strong> {{ $story->description }}</p>
                        @endif
                    </div>

                    <!-- Botão de Exclusão -->
                    <form method="POST"
                        action="{{ route('stories.destroy', ['capsule' => $capsule->id, 'story' => $story->id]) }}"
                        onsubmit="return confirm('Tem certeza que deseja excluir este story?');" class="absolute top-2 right-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="bg-red-600 hover:bg-red-700 text-white text-xs px-3 py-1 rounded-md shadow-md transition">
                            ✖️ Excluir
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    @endif

    <!-- Links de Navegação -->
    <div class="mt-8 text-center">
        @if (auth()->user()->id === $capsule->user_id)
            <!-- Link para Criadores -->
            <a href="{{ route('capsules.index') }}"
                class="inline-block mt-4 px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-lg shadow-md transition">
                🔙 Voltar à Listagem
            </a>
        @else
            <!-- Link para Convidados -->
            <a href="{{ route('guest-home') }}"
                class="inline-block mt-4 px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-bold rounded-lg shadow-md transition">
                🏠 Voltar para o Início
            </a>
        @endif
    </div>

    <script>
        // Efeito Fade-In
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

    <!-- Script para Manipular o Formulário -->
    <!-- Script para Manipulação do Campo de Duração -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const mediaInput = document.getElementById('media_file');
            const durationInput = document.getElementById('duration');
            const durationInfo = document.getElementById('duration-info');

            mediaInput.addEventListener('change', function () {
                const file = mediaInput.files[0];
                if (!file) return;

                const fileType = file.type;

                if (fileType.startsWith('image/')) {
                    // Se for uma imagem, desabilita o campo de duração
                    durationInput.value = 10; // Define um padrão para fotos
                    durationInput.disabled = true;
                    durationInfo.classList.remove('hidden');
                } else if (fileType.startsWith('video/')) {
                    // Se for um vídeo, habilita o campo de duração
                    durationInput.disabled = false;
                    durationInfo.classList.add('hidden');
                } else {
                    // Tipo de arquivo inválido
                    durationInput.disabled = true;
                    durationInfo.classList.add('hidden');
                }
            });
        });
    </script>
    @endsection