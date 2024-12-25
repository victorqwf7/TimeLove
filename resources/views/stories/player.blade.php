@extends('layouts.criador-layout')

@section('content')
<div class="relative w-full h-screen overflow-hidden">
    <!-- Player de Stories -->
    <div id="story-player" class="relative w-full h-full">
        <!-- Barra de Progresso -->
        <div class="progress-container fixed top-4 left-4 right-4 flex gap-2 z-50">
            @foreach($stories as $index => $story)
                <div class="progress-bar flex-1 bg-gray-300 rounded-full overflow-hidden">
                    <div class="progress-bar-inner bg-blue-500 h-full transition-all duration-linear"
                        data-index="{{ $index }}"></div>
                </div>
            @endforeach
        </div>

        <!-- Conteúdo da Story -->
        <div id="story-content" class="absolute inset-0 flex items-center justify-center z-10">
            <!-- O conteúdo da story (imagem ou vídeo) será injetado aqui via JavaScript -->
        </div>
    </div>

    <!-- Adicionar o CSS aqui -->
    <style>
        /* Barra de Progresso */
        .progress-container {
            /* Fixed position ensures it stays on top */
            position: fixed;
            top: 10px;
            left: 10px;
            right: 10px;
            display: flex;
            gap: 2px;
            z-index: 50;
            /* Alta prioridade para sobrepor as mídias */
        }

        .progress-bar {
            flex: 1;
            height: 4px;
            background-color: rgba(255, 255, 255, 0.3);
            /* Cor base da barra */
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
            background-color: transparent;
            /* Fundo transparente */
            position: relative;
            width: 100%;
            height: 100vh;
            /* Ocupa toda a altura da janela */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Estilização das Mídias */
        #story-content img,
        #story-content video {
            border-radius: 8px;
            max-width: 100%;
            /* Ocupa todo o espaço horizontal disponível */
            max-height: 100%;
            /* Ocupa todo o espaço vertical disponível */
            object-fit: contain;
            /* Mantém a proporção sem distorcer */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.5);
            /* Sombra para destacar */
            transition: opacity 0.5s ease-in-out;
            /* Transição suave */
            opacity: 0;
            /* Inicialmente invisível */
            z-index: 10;
            /* Inferior ao progress-container */
        }

        #story-content img.show,
        #story-content video.show {
            opacity: 1;
            /* Visível quando a classe 'show' é adicionada */
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .progress-container {
                top: 2rem;
                left: 1rem;
                right: 1rem;
            }

            #story-content img,
            #story-content video {
                max-height: 80%;
                /* Reduz a altura máxima em dispositivos menores */
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stories = @json($stories);
            let currentIndex = 0;
            let timer;
            const storyContent = document.getElementById('story-content');
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
                if (story.media_type === 'image') {
                    const img = document.createElement('img');
                    img.src = "{{ asset('storage') }}/" + story.media_path;
                    img.alt = "Story da Cápsula {{ $capsule->name }} - {{ $index + 1 }} de {{ $stories->count() }}";
                    img.classList.add('show');
                    storyContent.appendChild(img);
                } else if (story.media_type === 'video') {
                    const video = document.createElement('video');
                    video.src = "{{ asset('storage') }}/" + story.media_path;
                    video.autoplay = true;
                    video.classList.add('show');
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