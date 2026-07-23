<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class SeoController extends Controller
{
    public function sitemap(): Response
    {
        return response()
            ->view('sitemap', ['urls' => $this->sitemapUrls()])
            ->header('Content-Type', 'application/xml');
    }

    public function robots(): Response
    {
        $lines = collect(['User-agent: *'])
            ->merge($this->robotsDisallowPaths()->map(fn (string $path): string => "Disallow: {$path}"))
            ->push('Sitemap: '.url('/sitemap.xml'))
            ->implode(PHP_EOL);

        return response($lines.PHP_EOL, 200)->header('Content-Type', 'text/plain');
    }

    /** @return array<int, string> */
    private function sitemapUrls(): array
    {
        return $this->configuredPaths('app_settings.seo.sitemap_paths')
            ->map(fn (string $path): string => url($path))
            ->all();
    }

    /** @return Collection<int, string> */
    private function robotsDisallowPaths(): Collection
    {
        return $this->configuredPaths('app_settings.seo.robots_disallow')
            ->reject(fn (string $path): bool => $path === '/');
    }

    /** @return Collection<int, string> */
    private function configuredPaths(string $key): Collection
    {
        return collect(config($key, []))
            ->map(fn (string $path): string => trim($path))
            ->filter()
            ->map(fn (string $path): string => str_starts_with($path, '/') ? $path : "/{$path}")
            ->unique()
            ->values();
    }
}
