<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CriadorHomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CapsuleController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\Auth\ChooseRoleController;
use App\Http\Middleware\EnsureUserIsCreator;
use App\Http\Middleware\EnsureUserIsGuest;
use Illuminate\Support\Facades\Route;

// **Rota Principal**
Route::get('/', function () {
    return view('landing');
})->name('landing');

// **Rotas de Autenticação e Escolha de Papel**
Route::middleware(['auth'])->group(function () {
    Route::get('/choose-role', [ChooseRoleController::class, 'index'])->name('choose-role');
    Route::post('/choose-role', [ChooseRoleController::class, 'store'])->name('role.store');

    Route::get('/dashboard', function () {
        $role = auth()->user()->role;

        if (!$role) {
            return redirect()->route('choose-role');
        }

        return $role === 'criador'
            ? redirect()->route('criador-home')
            : redirect()->route('guest-home');
    })->name('dashboard');
});

// **Rotas de Perfil do Usuário**
Route::middleware(['auth'])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

// **Rotas Específicas por Papel**
Route::middleware(['auth'])->group(function () {
    // Home do Criador
    Route::get('/criador-home', [CriadorHomeController::class, 'index'])
        ->middleware(EnsureUserIsCreator::class)
        ->name('criador-home');

    // Home do Convidado
    Route::get('/guest-home', [GuestController::class, 'index'])
        ->middleware(EnsureUserIsGuest::class)
        ->name('guest-home');
});

// **Rotas para Cápsulas**
Route::middleware(['auth'])->prefix('capsules')->name('capsules.')->group(function () {
    // Acesso somente para Criadores
    Route::middleware([EnsureUserIsCreator::class])->group(function () {
        Route::get('/', [CapsuleController::class, 'index'])->name('index');
        Route::get('/create', [CapsuleController::class, 'create'])->name('create');
        Route::post('/store', [CapsuleController::class, 'store'])->name('store');
        Route::get('/{capsule}/edit', [CapsuleController::class, 'edit'])->name('edit');
        Route::put('/{capsule}', [CapsuleController::class, 'update'])->name('update');
        Route::delete('/{capsule}', [CapsuleController::class, 'destroy'])->name('destroy');
        Route::post('/{capsule}/share', [CapsuleController::class, 'share'])->name('share');
    });

    // Acesso compartilhado para Criadores e Convidados
    Route::get('/{capsule}', [CapsuleController::class, 'show'])->name('show');
});

// **Rotas para Stories (Relacionadas a Cápsulas)**
Route::middleware(['auth'])->prefix('capsules/{capsule}/stories')->name('stories.')->group(function () {
    Route::middleware(EnsureUserIsCreator::class)->group(function () {
        Route::post('/', [StoryController::class, 'store'])->name('store');
        Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy');
    });

    // Acesso ao player permitido para criadores e convidados compartilhados
    Route::get('/player', [StoryController::class, 'player'])->name('player');
});

// **Rotas de Autenticação (Fornecidas pelo Breeze)**
require __DIR__ . '/auth.php';