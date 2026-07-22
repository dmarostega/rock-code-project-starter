<?php

namespace App\Services;

use App\Exceptions\MediaProcessingException;
use App\Models\MediaAsset;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Exceptions\RuntimeException as ImageRuntimeException;
use Intervention\Image\ImageManager;
use RuntimeException;

class MediaService
{
    public function store(UploadedFile $file, User $user, ?string $altText = null): MediaAsset
    {
        $disk = (string) config('media.disk');
        $directory = trim((string) config('media.directory'), '/').'/'.now()->format('Y/m');
        $isImage = Str::startsWith((string) $file->getMimeType(), 'image/');

        if ($isImage) {
            if (! $this->canProcessImage($file)) {
                return $this->storeOriginalImage($file, $user, $directory, $disk, $altText);
            }

            try {
                $image = ImageManager::withDriver((string) config('media.image.driver'))
                    ->read($file)
                    ->scaleDown(width: (int) config('media.image.max_width'));
                $contents = $image->toWebp(quality: (int) config('media.image.quality'));
            } catch (ImageRuntimeException $exception) {
                throw new MediaProcessingException('Unable to process the uploaded image.', previous: $exception);
            }

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

    protected function canProcessImage(UploadedFile $file): bool
    {
        if (config('media.image.driver') !== GdDriver::class) {
            return true;
        }

        return match ($file->getMimeType()) {
            'image/jpeg' => function_exists('imagecreatefromjpeg') && function_exists('imagewebp'),
            'image/png' => function_exists('imagecreatefrompng') && function_exists('imagewebp'),
            'image/webp' => function_exists('imagecreatefromwebp') && function_exists('imagewebp'),
            default => false,
        };
    }

    private function storeOriginalImage(
        UploadedFile $file,
        User $user,
        string $directory,
        string $disk,
        ?string $altText,
    ): MediaAsset {
        $dimensions = @getimagesize($file->getRealPath());

        if ($dimensions === false) {
            throw new MediaProcessingException('Unable to validate the uploaded image.');
        }

        $extension = $file->extension() ?: 'image';
        $path = $file->storeAs($directory, Str::ulid().'.'.$extension, $disk);

        if (! $path) {
            throw new RuntimeException('Unable to store the image.');
        }

        return MediaAsset::create([
            'user_id' => $user->id,
            'disk' => $disk,
            'path' => $path,
            'original_name' => $file->getClientOriginalName(),
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'kind' => 'image',
            'width' => $dimensions[0] ?? null,
            'height' => $dimensions[1] ?? null,
            'alt_text' => $altText,
        ]);
    }
}
