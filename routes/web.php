<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CriadorHomeController;
use App\Http\Controllers\GuestController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->get('/dashboard', function () {
    $role = auth()->user()->role;

    if ($role === 'criador') {
        // Se for criador, pode acessar a página de dashboard
        return view('dashboard');  // Ou redirecionar para criador-home, caso queira uma página exclusiva para o criador
    } elseif ($role === 'convidado') {
        // Se for convidado, redireciona para a home de convidados
        return redirect()->route('guest-home');
    }

    // Se o usuário não tiver um papel definido, redireciona para a home geral ou uma página de erro
    return view('dashboard');
})->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rota para a página de criador, acessível somente por criadores
Route::middleware(['auth'])->get('/criador-home', [CriadorHomeController::class, 'index'])->name('criador-home');
// Rota para a página de convidados, acessível somente por convidados
Route::middleware(['auth'])->get('/guest-home', [GuestController::class, 'index'])->name('guest-home');

require __DIR__ . '/auth.php';
