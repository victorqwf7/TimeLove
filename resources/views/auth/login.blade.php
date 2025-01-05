@extends('layouts.auth-layout')

@section('content')
<form method="POST" action="{{ route('login') }}">
    @csrf

    <!-- Email Address -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium">Email</label>
        <input id="email" name="email" type="email" required
            class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Password -->
    <div class="mb-4">
        <label for="password" class="block text-sm font-medium">Senha</label>
        <input id="password" name="password" type="password" required
            class="w-full px-4 py-2 rounded-lg bg-gray-700 text-white focus:ring-2 focus:ring-blue-500">
    </div>

    <!-- Remember Me -->
    <div class="flex items-center justify-between mb-4">
        <label class="inline-flex items-center">
            <input type="checkbox" name="remember" class="text-blue-500">
            <span class="ml-2 text-sm">Lembrar-me</span>
        </label>
        <a href="{{ route('password.request') }}" class="text-blue-400 hover:underline text-sm">Esqueceu sua senha?</a>
    </div>

    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 rounded-lg shadow-md">
        Entrar
    </button>

    <p class="mt-4 text-center text-sm">Ainda não tem uma conta?
        <a href="{{ route('register') }}" class="text-blue-400 hover:underline">Cadastre-se</a>
    </p>
    <p class="mt-4 text-center text-sm">
        <a href="{{ route('landing') }}" class="text-blue-400 hover:underline">Voltar para o Início</a>
    </p>
</form>
@endsection