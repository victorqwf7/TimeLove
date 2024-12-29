<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Capsule;

class EnsureUserIsCreator
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();
        $capsule = $request->route('capsule'); // Obtém a cápsula da rota

        if (!$capsule) {
            abort(404, 'Cápsula não encontrada.');
        }

        // ✅ Verifica se o usuário é criador da cápsula
        if ($user->role === 'criador' && $capsule->user_id === $user->id) {
            return $next($request);
        }

        // ✅ Verifica se o usuário convidado tem acesso compartilhado
        if ($user->role === 'convidado' && $capsule->sharedWith()->where('user_id', $user->id)->exists()) {
            return $next($request);
        }

        // ❌ Se não passar nenhuma das verificações, bloqueia o acesso
        abort(403, 'Acesso negado. Você não tem permissão para acessar esta cápsula.');
    }
}