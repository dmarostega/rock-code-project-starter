<?php

use App\Models\User;
use App\Support\Seo\SeoData;
use Inertia\Testing\AssertableInertia as Assert;

it('renders the home page and sitemap', function (): void {
    $this->withoutVite();

    $this->get('/')->assertOk();
    $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml');
});

it('keeps private pages out of the sitemap', function (): void {
    config(['app_settings.seo.sitemap_paths' => ['/', '/sobre']]);

    $this->get('/sitemap.xml')
        ->assertOk()
        ->assertSee(url('/'), false)
        ->assertSee(url('/sobre'), false)
        ->assertDontSee('/login', false)
        ->assertDontSee('/register', false)
        ->assertDontSee('/dashboard', false)
        ->assertDontSee('/admin', false)
        ->assertDontSee('/profile', false)
        ->assertDontSee('/settings', false);
});

it('renders a minimal robots file by default', function (): void {
    $this->get('/robots.txt')
        ->assertOk()
        ->assertHeader('Content-Type', 'text/plain; charset=utf-8')
        ->assertSee('User-agent: *', false)
        ->assertDontSee('Disallow:', false)
        ->assertSee('Sitemap: '.url('/sitemap.xml'), false);
});

it('renders configured robots disallow rules when explicitly set', function (): void {
    config(['app_settings.seo.robots_disallow' => ['/tmp', 'preview']]);

    $this->get('/robots.txt')
        ->assertOk()
        ->assertSee('Disallow: /tmp', false)
        ->assertSee('Disallow: /preview', false)
        ->assertSee('Sitemap: '.url('/sitemap.xml'), false);
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

it('renders the maintenance page with noindex metadata', function (): void {
    $this->withoutVite();

    $this->get('/maintenance')->assertInertia(fn (Assert $page) => $page
        ->component('Maintenance')
        ->where('seo.robots', 'noindex,nofollow')
    );
});

it('renders mapped HTTP errors with noindex metadata', function (string $path, string $component, int $status): void {
    $this->withoutVite();

    if ($status === 403) {
        $this->actingAs(User::factory()->create());
    }

    $this->get($path)->assertStatus($status)->assertInertia(fn (Assert $page) => $page
        ->component($component)
        ->where('seo.robots', 'noindex,nofollow')
    );
})->with([
    ['/admin', 'Errors/Forbidden', 403],
    ['/missing-page', 'Errors/NotFound', 404],
]);
