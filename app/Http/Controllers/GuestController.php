<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'convidado') {
            return redirect()->route('dashboard')->with('error', 'Acesso negado.');
        }

        return view('guest-home');
    }
}
