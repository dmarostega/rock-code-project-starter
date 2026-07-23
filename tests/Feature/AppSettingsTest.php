<?php

use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

it('shares public app settings with inertia pages', function (): void {
    config([
        'app_settings.public_name' => 'Produto Publico',
        'app_settings.contact' => [
            'name' => 'Atendimento',
            'email' => 'contato@example.com',
            'phone' => '+55 11 99999-0000',
            'url' => 'https://example.com/contato',
        ],
        'app_settings.flags' => [
            'public_registration' => true,
            'media_uploads' => false,
            'growth_tracking' => false,
        ],
    ]);

    $this->actingAs(User::factory()->create())->get('/dashboard')->assertInertia(fn (Assert $page) => $page
        ->component('Dashboard')
        ->where('appName', 'Produto Publico')
        ->where('appSettings.publicName', 'Produto Publico')
        ->where('appSettings.contact.email', 'contato@example.com')
        ->where('appSettings.flags.public_registration', true)
        ->where('appSettings.flags.media_uploads', false)
        ->where('appSettings.flags.growth_tracking', false)
    );
});
