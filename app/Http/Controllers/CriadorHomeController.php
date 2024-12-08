<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CriadorHomeController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'criador') {
            return redirect()->route('dashboard');
        }
        return view('criador-home');
    }
}
