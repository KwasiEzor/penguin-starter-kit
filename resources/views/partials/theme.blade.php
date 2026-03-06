@php
    $css = app(\App\Services\ThemeService::class)->generateCss();
@endphp

@if ($css !== '')
    <style id="theme-overrides">{!! $css !!}</style>
@endif
