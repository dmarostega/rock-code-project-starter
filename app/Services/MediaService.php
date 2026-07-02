<?php

namespace App\Services;

use App\Models\MediaAsset;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;
use RuntimeException;

class MediaService
{
    public function store(UploadedFile $file, User $user, ?string $altText = null): MediaAsset
    {
        $disk = (string) config('media.disk');
        $directory = trim((string) config('media.directory'), '/').'/'.now()->format('Y/m');
        $isImage = Str::startsWith((string) $file->getMimeType(), 'image/');

        if ($isImage) {
            $image = Image::read($file)->scaleDown(width: (int) config('media.image.max_width'));
            $contents = $image->toWebp(quality: (int) config('media.image.quality'));
            $path = $directory.'/'.Str::ulid().'.webp';

            if (! Storage::disk($disk)->put($path, (string) $contents)) {
                throw new RuntimeException('Não foi possível armazenar a imagem.');
            }

            return MediaAsset::create([
                'user_id' => $user->id,
                'disk' => $disk,
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type' => 'image/webp',
                'size' => Storage::disk($disk)->size($path),
                'kind' => 'image',
                'width' => $image->width(),
                'height' => $image->height(),
                'alt_text' => $altText,
            ]);
        }

        $path = $file->storeAs($directory, Str::ulid().'.'.$file->extension(), $disk);

        if (! $path) {
            throw new RuntimeException('Não foi possível armazenar o arquivo.');
        }

        return MediaAsset::create([
            'user_id' => $user->id,
            'disk' => $disk,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'kind' => 'document',
            'alt_text' => $altText,
        ]);
    }

    public function delete(MediaAsset $asset): void
    {
        Storage::disk($asset->disk)->delete($asset->path);
        $asset->delete();
    }
}
