<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Buscar cápsulas compartilhadas com o usuário logado
        $sharedCapsules = $user->sharedCapsules()->with('user')->get();

        // Buscar stories recentes das cápsulas compartilhadas
        $recentStories = collect();
        foreach ($sharedCapsules as $capsule) {
            $recentStories = $recentStories->merge($capsule->stories()->latest()->take(3)->get());
        }

        return view('guest-home', [
            'sharedCapsules' => $sharedCapsules,
            'recentStories' => $recentStories,
        ]);
    }
}
