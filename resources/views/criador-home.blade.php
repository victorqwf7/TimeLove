<!-- resources/views/criador-home.blade.php -->
<x-app-layout>
    <!-- Passando conteúdo personalizado para o header -->
    <x-slot name="header">
        <h2 class="font-semibold text-3xl text-white leading-tight">
            Bem-vindo à sua página Criador
        </h2>
    </x-slot>

    <!-- Conteúdo da página específico para o criador -->
    <div class="py-16 bg-gradient-to-r from-blue-500 to-teal-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-2xl rounded-lg mb-12">
                <h3 class="text-4xl text-center font-bold text-teal-600 mb-6">Conteúdo Exclusivo para Criadores</h3>
                <p class="text-xl text-center text-gray-700 mb-8">
                    Aqui você pode criar e organizar seus projetos de maneira eficiente.
                </p>

                <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                    <!-- Card 1 -->
                    <div
                        class="flex flex-col items-center bg-white rounded-lg shadow-lg p-8 transition-transform transform hover:scale-105 hover:shadow-xl">
                        <div class="bg-teal-500 text-white rounded-full p-6 mb-6">
                            <i class="fas fa-pencil-alt text-4xl"></i> <!-- Ícone de edição -->
                        </div>
                        <h3 class="text-xl font-semibold mb-6">Gerenciar Projetos</h3>
                        <p class="text-gray-600 text-center mb-6">Crie e organize seus projetos de forma simples e
                            rápida.</p>
                        <a href="#" class="text-teal-500 hover:text-teal-700 font-semibold">Começar agora</a>
                    </div>

                    <!-- Card 2 -->
                    <div
                        class="flex flex-col items-center bg-white rounded-lg shadow-lg p-8 transition-transform transform hover:scale-105 hover:shadow-xl">
                        <div class="bg-blue-600 text-white rounded-full p-6 mb-6">
                            <i class="fas fa-users text-4xl"></i> <!-- Ícone de usuários -->
                        </div>
                        <h3 class="text-xl font-semibold mb-6">Interagir com Convidados</h3>
                        <p class="text-gray-600 text-center mb-6">Permita que convidados explorem e interajam com seu
                            conteúdo.</p>
                        <a href="#" class="text-blue-500 hover:text-blue-700 font-semibold">Saiba mais</a>
                    </div>

                    <!-- Card 3 -->
                    <div
                        class="flex flex-col items-center bg-white rounded-lg shadow-lg p-8 transition-transform transform hover:scale-105 hover:shadow-xl">
                        <div class="bg-orange-500 text-white rounded-full p-6 mb-6">
                            <i class="fas fa-cogs text-4xl"></i> <!-- Ícone de configurações -->
                        </div>
                        <h3 class="text-xl font-semibold mb-6">Configurações</h3>
                        <p class="text-gray-600 text-center mb-6">Ajuste suas preferências e personalize sua
                            experiência.</p>
                        <a href="#" class="text-orange-500 hover:text-orange-700 font-semibold">Acessar
                            configurações</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>