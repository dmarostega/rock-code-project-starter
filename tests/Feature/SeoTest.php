<?php

use App\Support\Seo\SeoData;

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
