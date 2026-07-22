<?php

namespace App\Providers;

use App\Models\MediaAsset;
use App\Policies\MediaAssetPolicy;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register project-specific bindings here.
    }

    public function boot(): void
    {
        Date::use(CarbonImmutable::class);
        DB::prohibitDestructiveCommands(app()->isProduction());
        Gate::policy(MediaAsset::class, MediaAssetPolicy::class);
        Schema::defaultStringLength(191);

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)->mixedCase()->letters()->numbers()->symbols()->uncompromised()
            : Password::min(8));
    }
}
