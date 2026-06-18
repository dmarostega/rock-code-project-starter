<?php

use App\Models\MediaAsset;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

it('stores an allowed document for an authenticated user', function (): void {
    Storage::fake('public');
    config(['media.disk' => 'public']);
    $user = User::factory()->create();

    $this->actingAs($user)->post('/media', [
        'file' => UploadedFile::fake()->create('briefing.pdf', 100, 'application/pdf'),
    ])->assertCreated();

    $asset = MediaAsset::query()->sole();
    expect($asset->user_id)->toBe($user->id)->and($asset->kind)->toBe('document');
    Storage::disk('public')->assertExists($asset->path);
});

it('prevents another user from deleting an asset', function (): void {
    $owner = User::factory()->create();
    $asset = MediaAsset::create(['user_id' => $owner->id, 'disk' => 'public', 'path' => 'media/test.pdf', 'original_name' => 'test.pdf', 'mime_type' => 'application/pdf', 'size' => 10, 'kind' => 'document']);

    $this->actingAs(User::factory()->create())->delete("/media/{$asset->id}")->assertForbidden();
});
