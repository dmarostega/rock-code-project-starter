<?php

namespace App\Policies;

use App\Models\MediaAsset;
use App\Models\User;

class MediaAssetPolicy
{
    public function delete(User $user, MediaAsset $asset): bool
    {
        return $asset->user_id === $user->id;
    }
}
