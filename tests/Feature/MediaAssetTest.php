<?php

use App\Models\MediaAsset;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores an allowed document for an authenticated user', function (): void {
    Storage::fake('public');
    config(['media.disk' => 'public']);
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/media', [
        'file' => UploadedFile::fake()->create('briefing.pdf', 100, 'application/pdf'),
        'alt_text' => 'Briefing comercial',
    ])->assertCreated();

    $asset = MediaAsset::query()->sole();
    expect($asset->user_id)->toBe($user->id)->and($asset->kind)->toBe('document');
    Storage::disk('public')->assertExists($asset->path);

    expect(array_keys($response->json('data')))->toBe([
        'id',
        'kind',
        'mime_type',
        'size',
        'width',
        'height',
        'alt_text',
        'display_name',
        'url',
    ])->and($response->json('data'))->toMatchArray([
        'id' => $asset->id,
        'kind' => 'document',
        'mime_type' => 'application/pdf',
        'size' => 102400,
        'width' => null,
        'height' => null,
        'alt_text' => 'Briefing comercial',
        'display_name' => 'Briefing comercial',
    ]);
});

it('processes an uploaded image with the configured Intervention driver', function (): void {
    Storage::fake('public');
    config(['media.disk' => 'public']);
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/media', [
        'file' => UploadedFile::fake()->image('banner.png', 3200, 1600),
        'alt_text' => 'Banner de teste',
    ])->assertCreated();

    $asset = MediaAsset::query()->sole();

    expect($asset)
        ->kind->toBe('image')
        ->mime_type->toBe('image/webp')
        ->width->toBe(2400)
        ->height->toBe(1200)
        ->alt_text->toBe('Banner de teste')
        ->and($asset->path)->toEndWith('.webp')
        ->and($response->json('data.mime_type'))->toBe('image/webp');

    Storage::disk('public')->assertExists($asset->path);
});

it('returns a controlled error when the image driver is unavailable', function (): void {
    Storage::fake('public');
    config([
        'media.disk' => 'public',
        'media.image.driver' => stdClass::class,
    ]);
    $user = User::factory()->create();

    $this->actingAs($user)->postJson('/media', [
        'file' => UploadedFile::fake()->image('banner.png'),
    ])->assertUnprocessable()->assertJson([
        'message' => 'Não foi possível processar a imagem enviada.',
    ]);

    expect(MediaAsset::query()->count())->toBe(0);
});

it('blocks uploads with a disallowed mime type', function (): void {
    Storage::fake('public');
    config(['media.disk' => 'public']);
    $user = User::factory()->create();

    $this->actingAs($user)->from('/dashboard')->post('/media', [
        'file' => UploadedFile::fake()->create('payload.txt', 10, 'text/plain'),
    ])->assertRedirect('/dashboard')->assertSessionHasErrors('file');

    expect(MediaAsset::query()->count())->toBe(0);
});

it('blocks uploads larger than the configured limit', function (): void {
    Storage::fake('public');
    config(['media.disk' => 'public', 'media.max_size_kb' => 100]);
    $user = User::factory()->create();

    $this->actingAs($user)->from('/dashboard')->post('/media', [
        'file' => UploadedFile::fake()->create('briefing.pdf', 101, 'application/pdf'),
    ])->assertRedirect('/dashboard')->assertSessionHasErrors('file');

    expect(MediaAsset::query()->count())->toBe(0);
});

it('blocks guests from uploading media', function (): void {
    Storage::fake('public');
    config(['media.disk' => 'public']);

    $this->post('/media', [
        'file' => UploadedFile::fake()->create('briefing.pdf', 100, 'application/pdf'),
    ])->assertRedirect('/login');

    expect(MediaAsset::query()->count())->toBe(0);
});

it('prevents another user from deleting an asset', function (): void {
    $owner = User::factory()->create();
    $asset = MediaAsset::create(['user_id' => $owner->id, 'disk' => 'public', 'path' => 'media/test.pdf', 'original_name' => 'test.pdf', 'mime_type' => 'application/pdf', 'size' => 10, 'kind' => 'document']);

    $this->actingAs(User::factory()->create())->delete("/media/{$asset->id}")->assertForbidden();
});
