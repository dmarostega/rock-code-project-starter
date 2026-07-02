<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMediaRequest;
use App\Models\MediaAsset;
use App\Services\MediaService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class MediaAssetController extends Controller
{
    public function store(StoreMediaRequest $request, MediaService $media): JsonResponse
    {
        $asset = $media->store($request->file('file'), $request->user(), $request->string('alt_text')->toString() ?: null);

        return response()->json(['data' => $asset], 201);
    }

    public function destroy(MediaAsset $mediaAsset, MediaService $media): RedirectResponse
    {
        $this->authorize('delete', $mediaAsset);
        $media->delete($mediaAsset);

        return back()->with('success', 'Arquivo removido.');
    }
}
