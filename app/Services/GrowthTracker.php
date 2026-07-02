<?php

namespace App\Services;

use App\Models\GrowthEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class GrowthTracker
{
    /** @param array<string, mixed> $data */
    public function record(Request $request, array $data): GrowthEvent
    {
        $attribution = $request->session()->get('growth.attribution', []);

        return GrowthEvent::create([
            'user_id' => $request->user()?->getAuthIdentifier(),
            'anonymous_id' => $data['anonymous_id'] ?? null,
            'name' => $data['name'],
            'path' => $data['path'] ?? $request->path(),
            'referrer' => $data['referrer'] ?? null,
            'source' => Arr::get($attribution, 'utm_source'),
            'medium' => Arr::get($attribution, 'utm_medium'),
            'campaign' => Arr::get($attribution, 'utm_campaign'),
            'metadata' => $data['metadata'] ?? [],
            'ip_hash' => hash_hmac('sha256', (string) $request->ip(), (string) config('app.key')),
            'user_agent' => mb_substr((string) $request->userAgent(), 0, 500),
        ]);
    }
}
