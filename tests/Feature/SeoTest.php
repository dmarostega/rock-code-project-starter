<?php

use App\Models\User;
use App\Support\Seo\SeoData;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the home page and sitemap', function (): void {
    $this->withoutVite();

    $this->get('/')->assertOk();
    $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml');
});

it('normalizes page metadata', function (): void {
    config(['app_settings.seo.title_suffix' => ' | Teste']);

    expect(SeoData::page('Página', '<strong>Descrição</strong>')->toArray())
        ->toMatchArray(['title' => 'Página | Teste', 'description' => 'Descrição']);
});

it('uses app settings as the source for default seo metadata', function (): void {
    config([
        'app_settings.seo.default_title' => 'Produto Teste',
        'app_settings.seo.default_description' => 'Descricao padrao revisavel.',
        'app_settings.seo.default_image' => '/images/social.png',
        'app_settings.seo.robots' => 'noindex,nofollow',
        'app_settings.seo.twitter_card' => 'summary',
    ]);

    expect(SeoData::defaults()->toArray())->toMatchArray([
        'title' => 'Produto Teste',
        'description' => 'Descricao padrao revisavel.',
        'image' => url('/images/social.png'),
        'robots' => 'noindex,nofollow',
        'twitterCard' => 'summary',
    ]);
});

it('marks private seo pages as noindex', function (): void {
    config(['app_settings.seo.title_suffix' => ' | Teste']);

    expect(SeoData::privatePage('Dashboard')->toArray())->toMatchArray([
        'title' => 'Dashboard | Teste',
        'robots' => 'noindex,nofollow',
    ]);
});

it('sets noindex metadata on auth pages', function (string $path, string $component): void {
    $this->withoutVite();

    $this->get($path)->assertInertia(fn (Assert $page) => $page
        ->component($component)
        ->where('seo.robots', 'noindex,nofollow')
    );
})->with([
    ['/login', 'auth/Login'],
    ['/register', 'auth/Register'],
    ['/forgot-password', 'auth/ForgotPassword'],
    ['/reset-password/test-token?email=cliente@example.com', 'auth/ResetPassword'],
]);

it('sets noindex metadata on authenticated private pages', function (string $path, string $component): void {
    $this->withoutVite();

    $user = User::factory()->create();

    $this->actingAs($user)->get($path)->assertInertia(fn (Assert $page) => $page
        ->component($component)
        ->where('seo.robots', 'noindex,nofollow')
    );
})->with([
    ['/dashboard', 'Dashboard'],
    ['/profile', 'Profile/Edit'],
]);
