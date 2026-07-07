@php
    $googleAnalyticsMeasurementId = trim((string) config('services.google_analytics.measurement_id'));
    $blockedGoogleAnalyticsHosts = ['localhost', '127.0.0.1', '0.0.0.0', '::1', '[::1]'];
    $currentHost = strtolower(request()->getHost());
    $googleAnalyticsEnabled = (bool) config('services.google_analytics.enabled')
        && app()->environment('production')
        && ! config('app.debug')
        && $googleAnalyticsMeasurementId !== ''
        && ! in_array($currentHost, $blockedGoogleAnalyticsHosts, true);
@endphp

@if ($googleAnalyticsEnabled)
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $googleAnalyticsMeasurementId }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', @js($googleAnalyticsMeasurementId));
    </script>
@endif
