<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CriadorHomeController extends Controller
{
    public function index()
    {
        // Caso contrário, retorna a página de dashboard para o criador
        return view('criador-home');
    }
}
