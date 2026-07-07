<?php

it('keeps google analytics disabled by default', function (): void {
    $this->view('partials.google-analytics')
        ->assertDontSee('googletagmanager.com', false)
        ->assertDontSee('gtag(', false);
});

function useRequestHost(string $host): void
{
    request()->headers->set('HOST', $host);
    request()->server->set('HTTP_HOST', $host);
}

it('renders google analytics only with production-safe configuration', function (): void {
    app()->detectEnvironment(fn (): string => 'production');

    config([
        'app.debug' => false,
        'services.google_analytics.enabled' => true,
        'services.google_analytics.measurement_id' => 'G-TEST123456',
    ]);

    useRequestHost('example.com');

    $this->view('partials.google-analytics')
        ->assertSee('https://www.googletagmanager.com/gtag/js?id=G-TEST123456', false)
        ->assertSee("gtag('config', 'G-TEST123456')", false);
});

it('blocks google analytics when app debug is enabled', function (): void {
    app()->detectEnvironment(fn (): string => 'production');

    config([
        'app.debug' => true,
        'services.google_analytics.enabled' => true,
        'services.google_analytics.measurement_id' => 'G-TEST123456',
    ]);

    useRequestHost('example.com');

    $this->view('partials.google-analytics')
        ->assertDontSee('googletagmanager.com', false)
        ->assertDontSee('gtag(', false);
});

it('blocks google analytics outside production', function (): void {
    app()->detectEnvironment(fn (): string => 'local');

    config([
        'app.debug' => false,
        'services.google_analytics.enabled' => true,
        'services.google_analytics.measurement_id' => 'G-TEST123456',
    ]);

    useRequestHost('example.com');

    $this->view('partials.google-analytics')
        ->assertDontSee('googletagmanager.com', false)
        ->assertDontSee('gtag(', false);
});

it('blocks google analytics on local hosts', function (string $host): void {
    app()->detectEnvironment(fn (): string => 'production');

    config([
        'app.debug' => false,
        'services.google_analytics.enabled' => true,
        'services.google_analytics.measurement_id' => 'G-TEST123456',
    ]);

    useRequestHost($host);

    $this->view('partials.google-analytics')
        ->assertDontSee('googletagmanager.com', false)
        ->assertDontSee('gtag(', false);
})->with(['localhost', '127.0.0.1', '0.0.0.0', '[::1]']);

it('keeps textual false google analytics config disabled', function (): void {
    $previousEnabled = getenv('GA_ENABLED');
    $previousMeasurementId = getenv('GA_MEASUREMENT_ID');

    try {
        putenv('GA_ENABLED=false');
        putenv('GA_MEASUREMENT_ID=G-TEST123456');
        $_ENV['GA_ENABLED'] = $_SERVER['GA_ENABLED'] = 'false';
        $_ENV['GA_MEASUREMENT_ID'] = $_SERVER['GA_MEASUREMENT_ID'] = 'G-TEST123456';

        $services = require base_path('config/services.php');

        expect($services['google_analytics']['enabled'])->toBeFalse()
            ->and($services['google_analytics']['measurement_id'])->toBe('G-TEST123456');
    } finally {
        if ($previousEnabled === false) {
            putenv('GA_ENABLED');
            unset($_ENV['GA_ENABLED'], $_SERVER['GA_ENABLED']);
        } else {
            putenv("GA_ENABLED={$previousEnabled}");
            $_ENV['GA_ENABLED'] = $_SERVER['GA_ENABLED'] = $previousEnabled;
        }

        if ($previousMeasurementId === false) {
            putenv('GA_MEASUREMENT_ID');
            unset($_ENV['GA_MEASUREMENT_ID'], $_SERVER['GA_MEASUREMENT_ID']);
        } else {
            putenv("GA_MEASUREMENT_ID={$previousMeasurementId}");
            $_ENV['GA_MEASUREMENT_ID'] = $_SERVER['GA_MEASUREMENT_ID'] = $previousMeasurementId;
        }
    }
});
