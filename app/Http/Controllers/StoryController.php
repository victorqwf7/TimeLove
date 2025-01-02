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
        // Validação dos dados
        $request->validate([
            'media_file' => 'required|file|mimes:jpeg,png,gif,mp4,avi|max:102400', // Máximo de 100MB
            'duration' => 'nullable|integer|min:1|max:30',
            'description' => 'nullable|string|max:255',
        ]);

        // Encontrar a cápsula
        $capsule = Capsule::findOrFail($capsule_id);

        // Obter o arquivo
        $file = $request->file('media_file');
        $mediaPath = $file->store('stories', 'public');
        $mediaType = $file->getMimeType();

        // Definir tipo de mídia e duração padrão
        if (str_starts_with($mediaType, 'image/')) {
            $type = 'image';
            $duration = 10; // Duração padrão para fotos
        } elseif (str_starts_with($mediaType, 'video/')) {
            $type = 'video';
            $duration = $request->duration ?? 10; // Padrão de 10 segundos se não fornecido
        } else {
            // Caso um tipo de arquivo não suportado passe pela validação (improvável)
            return redirect()->back()->with('error', 'Tipo de arquivo não suportado.');
        }

        // Salvar o Story no banco de dados
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
        $user = auth()->user();

        // Permitir acesso se o usuário for o criador da cápsula
        if ($user->id === $capsule->user_id) {
            $stories = $capsule->stories()->orderBy('created_at', 'asc')->get();

            return view('stories.player', [
                'capsule' => $capsule,
                'stories' => $stories,
            ]);
        }

        // Permitir acesso se o usuário for um convidado com acesso compartilhado
        if ($capsule->sharedWith()->where('user_id', $user->id)->exists()) {
            $stories = $capsule->stories()->orderBy('created_at', 'asc')->get();

            return view('stories.player', [
                'capsule' => $capsule,
                'stories' => $stories,
            ]);
        }

        // Bloquear acesso para qualquer outro usuário
        abort(403, 'Acesso negado. Você não tem permissão para acessar os stories desta cápsula.');
    }
}