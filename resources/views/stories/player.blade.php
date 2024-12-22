@extends('layouts.criador-layout')

@section('content')
<div class="container mx-auto px-4 py-6 text-white">
    <!-- Título da página -->
    <h1 class="text-3xl font-bold mb-6">Player de Stories - {{ $capsule->name }}</h1>

    <!-- Player de Stories -->
    <!-- Player de Stories -->
    <div id="story-player" class="relative w-full h-screen bg-black flex items-center justify-center">
        <!-- Barra de Progresso -->
        <div class="progress-container">
            @foreach($stories as $index => $story)
                <div class="progress-bar">
                    <div class="progress-bar-inner" data-index="{{ $index }}"></div>
                </div>
            @endforeach
        </div>

        <div id="story-content" class="w-full h-full flex items-center justify-center">
            <!-- O conteúdo da story (imagem ou vídeo) será injetado aqui via JavaScript -->
        </div>
        <!-- Removido os botões de navegação -->
    </div>

    <!-- Adicionar o CSS aqui -->
    <style>
        /* Barra de Progresso */
        .progress-container {
            position: absolute;
            top: 10px;
            left: 10px;
            right: 10px;
            display: flex;
            gap: 2px;
        }

        .progress-bar {
            flex: 1;
            height: 4px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
            overflow: hidden;
        }

        .progress-bar-inner {
            height: 100%;
            width: 0%;
            background-color: #3b82f6;
            /* Azul do Tailwind */
            transition: width linear;
        }

        /* Estilização do Player */
        #story-player {
            /* background-color: rgba(50, 50, 50, 0.95); Removido para eliminar o fundo */
            position: relative;
            width: 100%;
            height: 100vh;
            /* Ocupa toda a altura da janela */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #story-content img,
        #story-content video {
            border-radius: 8px;
            max-width: 90%;
            /* Limita a largura máxima */
            max-height: 90%;
            /* Limita a altura máxima */
            object-fit: contain;
            /* Mantém a proporção sem distorcer */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            /* Sombra para destacar */
            transition: opacity 0.5s ease-in-out;
            /* Transição suave */
            opacity: 0;
        }

        #story-content img.show,
        #story-content video.show {
            opacity: 1;
        }

        #prev-story::before,
        #next-story::before {
            content: '';
            display: inline-block;
            width: 1em;
            height: 1em;
            background-size: contain;
            background-repeat: no-repeat;
        }

        #prev-story::before {
            background-image: url('data:image/svg+xml;base64,PHN2ZyBmaWxsPSIjZmZmIiBoZWlnaHQ9IjE2IiB2aWV3Qm94PSIwIDAgMTYgMTYiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMu/b3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTAuODUgMTAgNy45NjQgNC45NTQgMTMuNDkgOS4wNjcgMS4zMjIgNi44NTkgNy4yNzIgOS45OTUgMS45NTRrLTUuNjk2IDQuNjA4Ii8+PC9zdmc+');
        }

        #next-story::before {
            background-image: url('data:image/svg+xml;base64,PHN2ZyBmaWxsPSIjZmZmIiBoZWlnaHQ9IjE2IiB2aWV3Qm94PSIwIDAgMTYgMTYiIHdpZHRoPSIxNiIgeG1sbnM9Imh0dHA6Ly93d3cudzMu/b3JnLzIwMDAvc3ZnIj48cGF0aCBkPSJNMTAuODUgMTAgNy45NjQgMTAuMTA4IDMuMTE4IDE1LjA5M0gxMC44NSIgLz48L3N2Zz4=');
        }

        /* Responsividade */
        @media (max-width: 768px) {

            #prev-story,
            #next-story {
                padding: 8px;
                font-size: 2rem;
            }

            #story-content img,
            #story-content video {
                max-width: 95%;
                max-height: 80%;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stories = @json($stories);
            let currentIndex = 0;
            let timer;
            const storyContent = document.getElementById('story-content');
            const prevButton = document.getElementById('prev-story');
            const nextButton = document.getElementById('next-story');

            const progressBars = document.querySelectorAll('.progress-bar-inner');

            function showStory(index) {
                if (index < 0 || index >= stories.length) {
                    // Se não houver mais stories, redireciona para a página da cápsula
                    window.location.href = "{{ route('capsules.show', $capsule->id) }}";
                    return;
                }

                currentIndex = index;
                const story = stories[currentIndex];

                // Resetar todas as barras de progresso
                progressBars.forEach((bar, i) => {
                    bar.style.transition = 'none';
                    bar.style.width = '0%';
                });

                // Preencher a barra de progresso atual
                const currentBar = progressBars[currentIndex];
                // Forçar reflow para reiniciar a transição
                void currentBar.offsetWidth;
                currentBar.style.transition = 'width ' + (story.duration || 5) + 's linear';
                currentBar.style.width = '100%';

                // Limpa o conteúdo anterior
                storyContent.innerHTML = '';

                // Verifica o tipo de mídia e cria o elemento correspondente
                // Dentro da função showStory()
                if (story.media_type === 'image') {
                    const img = document.createElement('img');
                    img.src = "{{ asset('storage') }}/" + story.media_path;
                    img.alt = "Story Image";
                    img.classList.add('max-w-full', 'max-h-full', 'object-contain', 'rounded-lg', 'show');
                    storyContent.appendChild(img);
                } else if (story.media_type === 'video') {
                    const video = document.createElement('video');
                    video.src = "{{ asset('storage') }}/" + story.media_path;
                    video.autoplay = true;
                    video.classList.add('max-w-full', 'max-h-full', 'object-contain', 'rounded-lg', 'show');
                    storyContent.appendChild(video);
                }

                // Inicia o timer para avançar para a próxima story
                clearTimeout(timer);
                timer = setTimeout(() => {
                    showStory(currentIndex + 1);
                }, (story.duration || 5) * 1000); // Duração em segundos
            }

            // Inicia a exibição da primeira story
            if (stories.length > 0) {
                showStory(currentIndex);
            } else {
                // Se não houver stories, redireciona para a página da cápsula
                window.location.href = "{{ route('capsules.show', $capsule->id) }}";
            }
        });
    </script>
</div>
@endsection