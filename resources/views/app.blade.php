<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="theme-color" content="#0f172a">
    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">
    <title inertia>{{ config('app.name') }}</title>
    <script>
        (() => {
            const storageKey = 'rock-code-theme';
            const savedTheme = localStorage.getItem(storageKey);
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            const theme = savedTheme === 'light' || savedTheme === 'dark'
                ? savedTheme
                : prefersDark
                    ? 'dark'
                    : 'light';

            document.documentElement.classList.toggle('dark', theme === 'dark');
            document.documentElement.style.colorScheme = theme;
            document
                .querySelector('meta[name="theme-color"]')
                ?.setAttribute('content', theme === 'dark' ? '#020617' : '#f8fafc');
        })();
    </script>
    @include('partials.google-analytics')
    @vite(['resources/css/app.css', 'resources/js/app.ts'])
    @inertiaHead
</head>
<body class="antialiased">
    @inertia
</body>
</html>
