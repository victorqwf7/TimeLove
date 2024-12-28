<?php

namespace App\Http\Controllers;

use App\Models\Capsule;
use App\Models\Story;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    public function store(Request $request, $capsule_id)
    {
        $request->validate([
            'media_file' => 'required|file|mimes:jpeg,png,gif,mp4,avi|max:20480',
            'duration' => 'nullable|integer|min:1|max:30',
            'description' => 'nullable|string|max:255',
        ]);

        $capsule = Capsule::findOrFail($capsule_id);

        $file = $request->file('media_file');
        $mediaPath = $file->store('stories', 'public');
        $mediaType = $file->getMimeType();

        if (str_starts_with($mediaType, 'image/')) {
            $type = 'image';
            $duration = 10; // Duração padrão para fotos
        } elseif (str_starts_with($mediaType, 'video/')) {
            $type = 'video';
            $duration = $request->duration ?? 10; // Padrão de 10 segundos se não fornecido
        } else {
            return redirect()->back()->with('error', 'Tipo de arquivo não suportado.');
        }

        Story::create([
            'capsule_id' => $capsule->id,
            'media_type' => $type,
            'media_path' => $mediaPath,
            'duration' => $duration,
            'description' => $request->description,
        ]);

        return redirect()->back()->with('success', 'Story adicionado com sucesso!');
    }

    public function destroy($capsuleId, $storyId)
    {
        // Encontra o story pertencente à cápsula
        $story = Story::where('id', $storyId)->where('capsule_id', $capsuleId)->first();

        if (!$story) {
            return redirect()->back()->with('error', 'Story não encontrado.');
        }

        // Exclui o arquivo da mídia (se necessário)
        if (Storage::exists($story->media_path)) {
            Storage::delete($story->media_path);
        }

        // Exclui o story
        $story->delete();

        return redirect()->back()->with('success', 'Story excluído com sucesso!');
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