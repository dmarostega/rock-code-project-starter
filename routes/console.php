<?php

use App\Models\GrowthEvent;
use Illuminate\Support\Facades\Schedule;

Schedule::call(fn () => GrowthEvent::query()->where('created_at', '<', now()->subDays((int) config('growth.retention_days')))->delete())
    ->daily()
    ->name('prune-growth-events')
    ->withoutOverlapping();
