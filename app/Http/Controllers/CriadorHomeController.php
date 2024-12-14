<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CriadorHomeController extends Controller
{
    public function index()
    {
        // Verifica se o usuário tem o papel 'criador'
        if (auth()->user()->role !== 'criador') {
            // Se não for 'criador', redireciona para 'guest-home'
            return redirect()->route('guest-home')->with('error', 'Acesso negado.');
        }

        // Caso contrário, retorna a página de dashboard para o criador
        return view('criador-home');
    }
}
