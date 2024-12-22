<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CriadorHomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CapsuleController;
use App\Http\Controllers\StoryController;
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

Route::middleware(['auth'])->group(function () {
    Route::post('/capsule/store', [CapsuleController::class, 'store'])->name('capsule.store');
});

Route::get('/capsules', [CapsuleController::class, 'index'])->name('capsules.index');

Route::get('/capsules/{capsule}', [CapsuleController::class, 'show'])->name('capsules.show');

// Grupo com middleware de autenticação, caso esteja usando
Route::middleware(['auth'])->group(function () {
    // ... outras rotas

    // Rota para editar (exibe o formulário de edição)
    Route::get('/capsules/{capsule}/edit', [CapsuleController::class, 'edit'])->name('capsules.edit');

    // Rota para atualizar (envia o formulário de edição)
    Route::put('/capsules/{capsule}', [CapsuleController::class, 'update'])->name('capsules.update');

    // Rota para excluir
    Route::delete('/capsules/{capsule}', [CapsuleController::class, 'destroy'])->name('capsules.destroy');
});

Route::middleware(['auth'])->group(function () {
    // Rota para criar (inserir) uma story
    Route::post('/capsules/{capsule}/stories', [StoryController::class, 'store'])->name('stories.store');
});

// Rota para o player do story
Route::middleware(['auth'])->group(function () {
    // Outras rotas...

    // Rota para o Player de Stories
    Route::get('/capsules/{capsule}/stories/player', [StoryController::class, 'player'])->name('stories.player');
});

require __DIR__ . '/auth.php';
