@extends('layouts.criador-layout')

@section('content')

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

    #story-description {
        position: absolute;
        top: 60px;
        /* Ajuste conforme a barra de progresso */
        left: 0;
        right: 0;
        text-align: center;
        color: white;
        font-size: 1rem;
        font-weight: 500;
        z-index: 20;
        padding: 8px 12px;
    }

    #story-navigation {
        position: absolute;
        inset: 0;
        display: flex;
        z-index: 30;
    }

    #story-prev,
    #story-next {
        flex: 1;
        cursor: pointer;
        transition: background-color 0.3s;
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


<div class="relative w-full h-screen overflow-hidden">
    <!-- Player de Stories -->
    <div id="story-player" class="relative w-full h-full">
        <!-- Área de Navegação -->
        <div id="story-navigation" class="absolute inset-0 flex z-30">
            <!-- Área para voltar (esquerda) -->
            <div id="story-prev" class="flex-1"></div>
            <!-- Área para avançar (direita) -->
            <div id="story-next" class="flex-1"></div>
        </div>

        <!-- Barra de Progresso -->
        <div class="progress-container fixed top-4 left-4 right-4 flex gap-2 z-50">
            @foreach($stories as $index => $story)
                <div class="progress-bar flex-1 bg-gray-300 rounded-full overflow-hidden">
                    <div class="progress-bar-inner bg-blue-500 h-full transition-all duration-linear"
                        data-index="{{ $index }}"></div>
                </div>
            @endforeach
        </div>

        <!-- Descrição do Story -->
        <div id="story-description" class="absolute top-14 left-0 right-0 text-center text-white">
        </div>

        <!-- Conteúdo do Story -->
        <div id="story-content" class="absolute inset-0 flex items-center justify-center z-10"></div>
    </div>




    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stories = @json($stories);
            let currentIndex = 0;
            let timer;
            let isPaused = false;
            const storyDescription = document.getElementById('story-description');
            const storyContent = document.getElementById('story-content');
            const progressBars = document.querySelectorAll('.progress-bar-inner');
            const storyPrev = document.getElementById('story-prev');
            const storyNext = document.getElementById('story-next');
            const storyPlayer = document.getElementById('story-player');

            function showStory(index, restart = false) {
                if (index < 0) {
                    // Se estiver no primeiro story e clicar para voltar, reinicia o tempo
                    restartStory();
                    return;
                }

                if (index >= stories.length) {
                    // Se não houver mais stories, redireciona
                    window.location.href = "{{ route('capsules.show', $capsule->id) }}";
                    return;
                }

                currentIndex = index;
                const story = stories[currentIndex];

                // Resetar todas as barras de progresso
                progressBars.forEach((bar) => {
                    bar.style.transition = 'none';
                    bar.style.width = '0%';
                });

                // Ativar a barra atual
                const currentBar = progressBars[currentIndex];
                void currentBar.offsetWidth; // Forçar reflow
                currentBar.style.transition = 'width ' + (story.duration || 5) + 's linear';
                currentBar.style.width = '100%';

                // Exibir mídia
                storyContent.innerHTML = '';
                if (story.media_type === 'image') {
                    const img = document.createElement('img');
                    img.src = "{{ asset('storage') }}/" + story.media_path;
                    img.alt = "Story da Cápsula {{ $capsule->name }}";
                    img.classList.add('show');
                    storyContent.appendChild(img);
                } else if (story.media_type === 'video') {
                    const video = document.createElement('video');
                    video.src = "{{ asset('storage') }}/" + story.media_path;
                    video.autoplay = true;
                    video.classList.add('show');
                    storyContent.appendChild(video);
                }

                // Exibir descrição
                storyDescription.innerHTML = story.description || '';

                // Iniciar timer
                clearTimeout(timer);
                if (!restart) {
                    timer = setTimeout(() => {
                        if (!isPaused) showStory(currentIndex + 1);
                    }, (story.duration || 5) * 1000); // Duração em segundos
                }
            }

            function restartStory() {
                // Reinicia a barra de progresso e o timer do story atual
                const currentBar = progressBars[currentIndex];
                currentBar.style.transition = 'none';
                currentBar.style.width = '0%';
                void currentBar.offsetWidth; // Forçar reflow
                currentBar.style.transition = 'width ' + (stories[currentIndex].duration || 5) + 's linear';
                currentBar.style.width = '100%';

                clearTimeout(timer);
                timer = setTimeout(() => {
                    if (!isPaused) showStory(currentIndex + 1);
                }, (stories[currentIndex].duration || 5) * 1000);
            }

            // Navegação para próximo story
            storyNext.addEventListener('click', () => {
                showStory(currentIndex + 1);
            });

            // Navegação para story anterior
            storyPrev.addEventListener('click', () => {
                if (currentIndex === 0) {
                    restartStory(); // Reinicia o tempo se estiver no primeiro story
                } else {
                    showStory(currentIndex - 1);
                }
            });

            // Pausar ao segurar clique
            storyPlayer.addEventListener('mousedown', () => {
                isPaused = true;
                clearTimeout(timer);
                const currentBar = progressBars[currentIndex];
                currentBar.style.transition = 'none';
            });

            // Retomar ao soltar clique
            storyPlayer.addEventListener('mouseup', () => {
                isPaused = false;
                const currentBar = progressBars[currentIndex];
                currentBar.style.transition = 'width ' + (stories[currentIndex].duration || 5) + 's linear';
                const currentProgress = currentBar.offsetWidth / currentBar.parentElement.offsetWidth;
                const remainingTime = (1 - currentProgress) * (stories[currentIndex].duration || 5) * 1000;

                timer = setTimeout(() => {
                    showStory(currentIndex + 1);
                }, remainingTime);
            });

            // Iniciar player
            if (stories.length > 0) {
                showStory(currentIndex);
            } else {
                window.location.href = "{{ route('capsules.show', $capsule->id) }}";
            }
        });
    </script>
</div>
@endsection