<?php

namespace App\Http\Controllers;

use App\Exceptions\MediaProcessingException;
use App\Http\Requests\StoreMediaRequest;
use App\Http\Resources\MediaAssetResource;
use App\Models\MediaAsset;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class MediaAssetController extends Controller
{
    public function store(StoreMediaRequest $request, MediaService $media): JsonResponse
    {
        try {
            $asset = $media->store($request->file('file'), $request->user(), $request->string('alt_text')->toString() ?: null);
        } catch (MediaProcessingException) {
            return response()->json([
                'message' => 'Não foi possível processar a imagem enviada.',
            ], 422);
        }

        return response()->json(['data' => new MediaAssetResource($asset)], 201);
    }

    public function destroy(MediaAsset $mediaAsset, MediaService $media): RedirectResponse
    {
        $this->authorize('delete', $mediaAsset);
        $media->delete($mediaAsset);

        return back()->with('success', 'Arquivo removido.');
    }
}
