<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CriadorHomeController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'criador') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        return view('criador-home');
    }
}
