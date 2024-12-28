<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChooseRoleController extends Controller
{
    public function index()
    {
        return view('auth.choose-role');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role' => 'required|in:criador,convidado',
        ]);

        $user = auth()->user();
        $user->role = $validated['role'];
        $user->save();

        return $validated['role'] === 'criador'
            ? redirect()->route('criador-home')
            : redirect()->route('guest-home');
    }
}
