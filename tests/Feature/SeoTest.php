<?php

use App\Support\Seo\SeoData;

it('renders the home page and sitemap', function (): void {
    $this->withoutVite();

    $this->get('/')->assertOk();
    $this->get('/sitemap.xml')->assertOk()->assertHeader('Content-Type', 'application/xml');
});

it('normalizes page metadata', function (): void {
    config(['seo.title_suffix' => ' | Teste']);

    expect(SeoData::page('Página', '<strong>Descrição</strong>')->toArray())
        ->toMatchArray(['title' => 'Página | Teste', 'description' => 'Descrição']);
});
