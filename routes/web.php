<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CriadorHomeController;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\CapsuleController;
use App\Http\Controllers\StoryController;
use App\Http\Middleware\EnsureUserIsCreator;
use App\Http\Controllers\Auth\ChooseRoleController;
use Illuminate\Support\Facades\Route;

// **Rota Principal**
Route::get('/', function () {
    return view('welcome');
})->name('home');

// **Rotas de Autenticação e Escolha de Papel**
Route::middleware(['auth'])->group(function () {
    // Tela para escolher o papel
    Route::get('/choose-role', [ChooseRoleController::class, 'index'])->name('choose-role');
    Route::post('/choose-role', [ChooseRoleController::class, 'store'])->name('role.store');

    // Dashboard com redirecionamento baseado no papel
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
    // Home do Criador (Somente Criadores)
    Route::middleware([EnsureUserIsCreator::class])->get('/criador-home', [CriadorHomeController::class, 'index'])->name('criador-home');

    // Home do Convidado
    Route::get('/guest-home', [GuestController::class, 'index'])->name('guest-home');
});

// **Rotas para Cápsulas (Somente Criadores)**
Route::middleware(['auth', EnsureUserIsCreator::class])->prefix('capsules')->name('capsules.')->group(function () {
    Route::get('/', [CapsuleController::class, 'index'])->name('index');
    Route::get('/create', [CapsuleController::class, 'create'])->name('create');
    Route::post('/store', [CapsuleController::class, 'store'])->name('store');
    Route::get('/{capsule}', [CapsuleController::class, 'show'])->name('show');
    Route::get('/{capsule}/edit', [CapsuleController::class, 'edit'])->name('edit');
    Route::put('/{capsule}', [CapsuleController::class, 'update'])->name('update');
    Route::delete('/{capsule}', [CapsuleController::class, 'destroy'])->name('destroy');
});

// **Rotas para Stories (Relacionadas a Cápsulas)**
Route::middleware(['auth', EnsureUserIsCreator::class])->prefix('capsules/{capsule}/stories')->name('stories.')->group(function () {
    Route::post('/', [StoryController::class, 'store'])->name('store');
    Route::get('/player', [StoryController::class, 'player'])->name('player');
    Route::delete('/{story}', [StoryController::class, 'destroy'])->name('destroy');
});

// **Rotas de Autenticação (Fornecidas pelo Breeze)**
require __DIR__ . '/auth.php';