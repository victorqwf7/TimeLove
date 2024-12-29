<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Capsule;

class CapsuleController extends Controller
{

    public function index()
    {
        // Pega todas as cápsulas do usuário logado
        $capsules = Capsule::where('user_id', auth()->id())->get();

        // Retorna a view com todas as cápsulas
        return view('capsules.index', compact('capsules'));
    }

    public function share(Request $request, Capsule $capsule)
    {
        // Verifica se a cápsula pertence ao usuário logado
        if ($capsule->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }

        // Valida o e-mail do convidado
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        // Encontra o usuário pelo e-mail
        $guest = User::where('email', $request->email)->first();

        if ($guest->role !== 'convidado') {
            return redirect()->back()->with('error', 'Este usuário não é um convidado válido.');
        }

        // Adiciona o convidado à cápsula
        $capsule->guests()->attach($guest->id);

        return redirect()->back()->with('success', 'Cápsula compartilhada com sucesso!');
    }


    public function show(Capsule $capsule)
    {
        $user = auth()->user();

        // Permitir acesso se o usuário for o dono (criador) da cápsula
        if ($user->role === 'criador' && $capsule->user_id === $user->id) {
            $stories = $capsule->stories()->orderBy('created_at', 'desc')->get();
            return view('capsules.show', [
                'capsule' => $capsule,
                'stories' => $stories,
            ]);
        }

        // Permitir acesso se o usuário for um convidado e tiver acesso à cápsula
        if ($user->role === 'convidado' && $capsule->guests()->where('user_id', $user->id)->exists()) {
            $stories = $capsule->stories()->orderBy('created_at', 'desc')->get();
            return view('capsules.show', [
                'capsule' => $capsule,
                'stories' => $stories,
            ]);
        }

        // Se nenhuma das condições for verdadeira, negar acesso
        abort(403, 'Você não tem permissão para acessar esta cápsula.');
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
}