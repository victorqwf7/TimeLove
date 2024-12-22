@extends('layouts.guest-layout')

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
<div class="h-screen flex flex-col">
    <!-- Main Content -->
    <main class="">
        <section class="flex justify-center min-h-screen mt-32 text-white">
            <div class="fade-in">
                <div class="justify-items-center">
                    <p class="text-2xl">Bem-vinda, {{ auth()->user()->name }}!</p>
                </div>
                <div class="m-8 justify-items-center">
                    <p class="text">Esta é a tela de convidados.</p>
                    <p class="text">Vamos ver o que seu amor preparou para você no
                        TimeLove?
                    </p>
                </div>
            </div>
        </section>
        <section class="flex flex-col mb-20 text-black bg-slate-200 rounded-lg">
            <!-- Wrapper para aplicar fade-in em tudo -->
            <div class="scroll-fade-in" style="--delay: 0.2s">
                <!-- Primeira Linha -->
                <div class="flex justify-start items-center gap-2 p-4 bg-slate-200">
                    <h1 class="text-4xl scroll-fade-in" style="--delay: 0.3s">O que</h1>
                    <h1 class="text-4xl scroll-fade-in" style="--delay: 0.4s">está</h1>
                    <h1 class="text-4xl scroll-fade-in" style="--delay: 0.5s">te</h1>
                    <h1 class="text-4xl scroll-fade-in" style="--delay: 0.9s">esperando?</h1>
                </div>

                <!-- Botões com animação -->
                <div class="flex justify-around my-10">
                    <!-- Primeiro Botão -->
                    <button
                        class="p-8 bg-slate-900 rounded-lg m-2 text-white hover:text-rose-500 transition duration-300 scroll-fade-in"
                        style="--delay: 1.2s">
                        Cápsula do Tempo
                    </button>

                    <!-- Segundo Botão -->
                    <button
                        class="p-8 bg-slate-900 rounded-lg m-2 text-white hover:text-rose-500 transition duration-300 scroll-fade-in"
                        style="--delay: 1.5s">
                        Linha do Tempo
                    </button>
                </div>
            </div>
        </section>
    </main>
</div>


<script>
    // script fade ao rolar a página
    document.addEventListener('DOMContentLoaded', function () {
        const items = document.querySelectorAll('.scroll-fade-in');

        const handleScroll = () => {
            items.forEach((item) => {
                const rect = item.getBoundingClientRect();
                if (rect.top < window.innerHeight && rect.bottom > 0) {
                    item.classList.add('show');
                }
            });
        };

        // Detecta o scroll na página
        window.addEventListener('scroll', handleScroll);

        // Verifica os itens já visíveis na carga inicial
        handleScroll();
    });
</script>
@endsection