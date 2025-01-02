<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Capsule;
use App\Models\User;

class CapsuleController extends Controller
{

    public function index()
    {
        // Pega todas as cápsulas do usuário logado
        $capsules = Capsule::where('user_id', auth()->id())->get();

        // Retorna a view com todas as cápsulas
        return view('capsules.index', compact('capsules'));
    }


    public function show(Capsule $capsule)
    {
        $user = auth()->user();

        // Permitir acesso se for o criador da cápsula
        if ($user->id === $capsule->user_id) {
            $stories = $capsule->stories()->orderBy('created_at', 'desc')->get();

            return view('capsules.show', [
                'capsule' => $capsule,
                'stories' => $stories,
            ]);
        }

        // Permitir acesso se for um convidado com acesso compartilhado
        if ($capsule->sharedWith()->where('user_id', $user->id)->exists()) {
            $stories = $capsule->stories()->orderBy('created_at', 'desc')->get();

            return view('capsules.show', [
                'capsule' => $capsule,
                'stories' => $stories,
            ]);
        }

        // Bloquear acesso para qualquer outro usuário
        abort(403, 'Acesso negado. Você não tem permissão para acessar esta cápsula.');
    }

    public function store(Request $request)
    {
        // 1. Validar os dados
        $request->validate([
            'name' => 'required|max:255',
            'theme' => 'required|max:50',
        ]);

        // Salvar
        $capsule = Capsule::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'theme' => $request->theme,
        ]);
        return redirect()->route('capsules.index')->with('sucess', 'Capsula criada com sucesso!');
    }

    public function edit(Capsule $capsule)
    {
        // Verifica se a cápsula pertence ao usuário
        if ($capsule->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }
        return view('capsules.edit', compact('capsule'));
    }


    public function update(Request $request, Capsule $capsule)
    {
        if ($capsule->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }

        $request->validate([
            'name' => 'required|max:255',
            'theme' => 'required|max:50',
        ]);

        $capsule->update([
            'name' => $request->name,
            'theme' => $request->theme,
        ]);

        return redirect()->route('capsules.show', $capsule)->with('success', 'Cápsula atualizada com sucesso!');
    }

    public function destroy(Capsule $capsule)
    {
        if ($capsule->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }

        $capsule->delete();

        return redirect()->route('capsules.index')->with('success', 'Cápsula excluída com sucesso!');
    }


    public function share(Request $request, Capsule $capsule)
    {
        // Verifica se o usuário autenticado é o dono da cápsula
        if ($capsule->user_id !== auth()->id()) {
            abort(403, 'Acesso negado. Você não pode compartilhar esta cápsula.');
        }

        // Validação do e-mail do convidado
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        // Busca o usuário pelo e-mail
        $user = User::where('email', $request->email)->first();

        // Verifica se o usuário já tem acesso à cápsula
        if ($capsule->sharedWith()->where('user_id', $user->id)->exists()) {
            return back()->with('error', 'Este usuário já tem acesso à cápsula.');
        }

        // Compartilha a cápsula com o usuário
        $capsule->sharedWith()->attach($user->id);

        return back()->with('success', 'Cápsula compartilhada com sucesso!');
    }
}