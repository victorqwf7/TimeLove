<?php

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Garante que o usuário esteja autenticado
    }

    public function index()
    {
        $user = Auth::user(); // Pega o usuário logado

        if ($user) {
            if ($user->role === 'admin') {
                $content = 'Bem-vindo, Admin!';
            } elseif ($user->role === 'criador') {
                $content = 'Bem-vindo, Criador!';
            } else {
                $content = 'Bem-vindo, Convidado!';
            }

            return view('dashboard', compact('content'));
        } else {
            return redirect()->route('login');
        }
    }
}
