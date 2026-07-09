<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Support\Seo\SeoData;
use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /** @return array<string, mixed> */
    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'appName' => config('app_settings.public_name'),
            'appSettings' => fn () => [
                'publicName' => config('app_settings.public_name'),
                'contact' => config('app_settings.contact'),
                'flags' => config('app_settings.flags'),
            ],
            'auth' => ['user' => $this->sharedUser($request->user())],
            'flash' => [
                'success' => fn () => $request->session()->get('success'),
                'error' => fn () => $request->session()->get('error'),
            ],
            'seo' => fn () => SeoData::defaults()->toArray(),
        ];
    }

    /** @return array{id: int, name: string, email: string}|null */
    private function sharedUser(?User $user): ?array
    {
        if ($user === null) {
            return null;
        }

        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
