<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<title>{{ config('app.name', 'Penguin Starter Kit') }}</title>

@stack('meta')

<!-- Fonts -->
@php
    $themeFont = app(\App\Services\ThemeService::class)->getFontFamily();
    $themeFontUrl = config('theme.fonts')[$themeFont] ?? config('theme.fonts')['Instrument Sans'];
@endphp
<link rel="preconnect" href="https://fonts.bunny.net" />
<link href="{{ $themeFontUrl }}&display=swap" rel="stylesheet" />

<!-- Scripts -->
@vite(['resources/css/app.css', 'resources/js/app.js'])

@include('partials.theme')
