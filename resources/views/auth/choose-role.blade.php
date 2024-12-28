<x-guest-layout>
    <div class="container mx-auto text-center mt-8">
        <h1 class="text-2xl font-bold mb-4">Escolha seu Tipo de Conta</h1>
        <p class="mb-6">Selecione uma das opções para continuar:</p>

        <form method="POST" action="{{ route('role.store') }}">
            @csrf
            <button name="role" value="criador"
                class="bg-blue-500 text-white px-4 py-2 rounded-md m-2 hover:bg-blue-600">
                Quero ser Criador
            </button>
            <button name="role" value="convidado"
                class="bg-fuchsia-500 text-black px-4 py-2 rounded-md m-2 hover:bg-fuchsia-600">
                Quero ser Convidado
            </button>
        </form>
    </div>
</x-guest-layout>