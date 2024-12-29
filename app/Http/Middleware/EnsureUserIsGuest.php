<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Capsule;

class EnsureUserIsGuest
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user->role !== 'convidado') {
            abort(403, 'Acesso negado. Apenas usuários convidados podem acessar esta página.');
        }

        return $next($request);
    }
}