<?php

namespace App\Http\Controllers;

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


    public function show(Capsule $capsule)
    {
        // Verifica se a cápsula pertence ao usuário
        if ($capsule->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }
        // Carrega as stories associadas à cápsula
        // (pode ordenar por created_at, se quiser)
        $stories = $capsule->stories()->orderBy('created_at', 'desc')->get();

        return view('capsules.show', [
            'capsule' => $capsule,
            'stories' => $stories,
        ]);
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