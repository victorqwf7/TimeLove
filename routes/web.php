<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CriadorHomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CapsuleController;
use App\Http\Controllers\StoryController;
use App\Http\Middleware\EnsureUserIsCreator;
use Illuminate\Support\Facades\Route;

// Rota Principal
Route::get('/', function () {
    return view('welcome');
});

// Grupo de Autenticação
Route::middleware(['auth'])->group(function () {
    // Dashboard com Redirecionamento por Role
    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if ($role === 'criador') {
            return view('dashboard');
        } elseif ($role === 'convidado') {
            return redirect()->route('guest-home');
        }

        return view('dashboard');
    })->name('dashboard');

    // Perfil do Usuário
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Home Criador e Convidado
    Route::get('/criador-home', [CriadorHomeController::class, 'index'])->middleware(['auth', EnsureUserIsCreator::class])->name('criador-home');
    Route::get('/guest-home', [GuestController::class, 'index'])->name('guest-home');

    // Rotas protegidas para usuários com role 'criador'
    Route::middleware(['auth', EnsureUserIsCreator::class])->prefix('capsules')->name('capsules.')->group(function () {
        Route::get('/', [CapsuleController::class, 'index'])->name('index');
        Route::get('/{capsule}', [CapsuleController::class, 'show'])->name('show');
        Route::get('/{capsule}/edit', [CapsuleController::class, 'edit'])->name('edit');
        Route::put('/{capsule}', [CapsuleController::class, 'update'])->name('update');
        Route::delete('/{capsule}', [CapsuleController::class, 'destroy'])->name('destroy');
        Route::post('/store', [CapsuleController::class, 'store'])->name('store');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/capsules/create', [CapsuleController::class, 'create'])->name('capsules.create');
    });

    // Grupo de Rotas para Stories
    Route::prefix('capsules/{capsule}/stories')->name('stories.')->group(function () {
        Route::post('/', [StoryController::class, 'store'])->name('store');
        Route::get('/player', [StoryController::class, 'player'])->name('player');
        Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy');
    });
});

// Autenticação
require __DIR__ . '/auth.php';