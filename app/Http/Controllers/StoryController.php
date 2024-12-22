<?php

namespace App\Http\Controllers;

use App\Models\Capsule;
use App\Models\Story;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function store(Request $request, Capsule $capsule)
    {
        $request->validate([
            'media_file' => 'required|file|mimetypes:image/*,video/*',
            'duration' => 'nullable|integer|min:1|max:30',
        ]);

        // Descobrir se é foto ou vídeo de acordo com o mimetype
        $mediaType = explode('/', $request->file('media_file')->getMimeType())[0]; // "image" ou "video"

        // Salvar o arquivo no storage
        // Ajuste o path se quiser "capsules/{capsule->id}/stories", por ex.
        $path = $request->file('media_file')->store('stories', 'public');

        // Criar a story
        $story = Story::create([
            'capsule_id' => $capsule->id,
            'media_type' => $mediaType, // "image" ou "video"
            'media_path' => $path,
            'duration' => $request->duration ?? 5,
        ]);

        return redirect()
            ->route('capsules.show', $capsule)
            ->with('success', 'Story criada com sucesso!');
    }

    /**
     * Exibe o player de stories para uma cápsula específica.
     *
     * @param  \App\Models\Capsule  $capsule
     * @return \Illuminate\View\View
     */
    public function player(Capsule $capsule)
    {
        // Verifica se a cápsula pertence ao usuário logado
        if ($capsule->user_id !== auth()->id()) {
            abort(403, 'Acesso negado');
        }

        // Carrega todas as stories associadas à cápsula, ordenadas pela data de criação
        $stories = $capsule->stories()->orderBy('created_at', 'asc')->get();

        // Retorna a view do player de stories, passando a cápsula e as stories
        return view('stories.player', [
            'capsule' => $capsule,
            'stories' => $stories,
        ]);
    }
}