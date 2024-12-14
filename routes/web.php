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
        return redirect()->route('criador-home');
    } elseif ($role === 'convidado') {
        return redirect()->route('guest-home');
    }

    return view('dashboard'); // Página padrão para outros papéis, se aplicável
})->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->get('/criador-home', [CriadorHomeController::class, 'index'])->name('criador-home');
Route::middleware(['auth'])->get('/guest-home', [GuestController::class, 'index'])->name('guest-home');


require __DIR__ . '/auth.php';
