<?php

use App\Models\GrowthEvent;

it('captures campaign attribution without storing a raw ip', function (): void {
    config(['growth.enabled' => true, 'app.key' => 'base64:test-key']);

    $this->get('/?utm_source=newsletter&utm_campaign=launch');
    $this->postJson('/growth/events', [
        'name' => 'cta.clicked',
        'anonymous_id' => 'c902bd23-0c2c-4d6e-b18c-011f5b11f171',
        'metadata' => ['placement' => 'hero'],
    ])->assertAccepted();

    $event = GrowthEvent::query()->sole();
    expect($event->source)->toBe('newsletter')
        ->and($event->campaign)->toBe('launch')
        ->and($event->ip_hash)->toHaveLength(64)
        ->and($event->ip_hash)->not->toContain('127.0.0.1');
});

it('rejects invalid event names', function (): void {
    $this->postJson('/growth/events', ['name' => 'Invalid Event'])->assertUnprocessable();
});
