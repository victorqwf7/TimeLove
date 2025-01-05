@extends('layouts.auth-layout')

@section('content')
<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div class="mb-4">
        <label for="name" class="block text-sm font-medium">Nome</label>
        <input id="name" name="name" type="text" required
            class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Email -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium">Email</label>
        <input id="email" name="email" type="email" required
            class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Gênero -->
    <div class="mb-4">
        <label for="gender" class="block text-sm font-medium">Gênero</label>
        <select id="gender" name="gender" required
            class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500 appearance-none">
            <option value="" disabled selected>Selecione seu gênero</option>
            <option value="male">Masculino</option>
            <option value="female">Feminino</option>
        </select>
        @error('gender')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium">Senha</label>
        <input id="password" name="password" type="password" required
            class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Confirm Password -->
    <div class="mb-4">
        <label for="password_confirmation" class="block text-sm font-medium">Confirmar Senha</label>
        <input id="password_confirmation" name="password_confirmation" type="password" required
            class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500">
    </div>

    <button type="submit" class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-2 rounded-lg shadow-md">
        Cadastrar
    </button>

    <p class="mt-4 text-center text-sm">Já tem uma conta?
        <a href="{{ route('login') }}" class="text-blue-400 hover:underline">Faça login</a>
    </p>
    <p class="mt-4 text-center text-sm">
        <a href="{{ route('landing') }}" class="text-blue-400 hover:underline">Voltar para o Início</a>
    </p>
</form>
@endsection