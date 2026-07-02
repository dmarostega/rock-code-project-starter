<?php

namespace App\Support\Seo;

use Illuminate\Support\Str;

final readonly class SeoData
{
    public function __construct(
        public string $title,
        public ?string $description = null,
        public ?string $image = null,
        public ?string $canonical = null,
        public string $robots = 'index,follow',
        public string $type = 'website',
    ) {}

    public static function defaults(): self
    {
        return new self(
            title: (string) config('seo.default_title'),
            description: config('seo.default_description'),
            image: self::absoluteUrl(config('seo.default_image')),
            canonical: url()->current(),
            robots: (string) config('seo.robots'),
        );
    }

    public static function page(string $title, ?string $description = null, ?string $image = null): self
    {
        return new self(
            title: $title.(string) config('seo.title_suffix'),
            description: $description ?? config('seo.default_description'),
            image: self::absoluteUrl($image ?? config('seo.default_image')),
            canonical: url()->current(),
            robots: (string) config('seo.robots'),
        );
    }

    /** @return array<string, string|null> */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description ? Str::limit(strip_tags($this->description), 160, '') : null,
            'image' => $this->image,
            'canonical' => $this->canonical,
            'robots' => $this->robots,
            'type' => $this->type,
            'twitterCard' => (string) config('seo.twitter_card'),
        ];
    }

    private static function absoluteUrl(?string $value): ?string
    {
        if (! $value) {
            return null;
        }

        return Str::startsWith($value, ['http://', 'https://']) ? $value : url($value);
    }
}
