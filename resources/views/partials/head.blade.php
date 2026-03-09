@php
    $websiteService = app(\App\Services\WebsiteService::class);
    $siteName = $websiteService->getSiteName();
    $seoTitle = $websiteService->getSeoTitle();
    $seoDescription = $websiteService->getSeoDescription();
    $seoKeywords = $websiteService->getSeoKeywords();
    $seoSocialImage = $websiteService->getSeoSocialImage();
    $favicon = $websiteService->getFavicon();
    $gaId = $websiteService->getGoogleAnalyticsId();
    $gtmId = $websiteService->getGtmId();
    $customHeaderScripts = $websiteService->getCustomScriptsHeader();
@endphp

<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}" />

<!-- SEO Meta Tags -->
<title>{{ $seoTitle }}</title>
<meta name="description" content="{{ $seoDescription }}">
<meta name="keywords" content="{{ $seoKeywords }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $seoTitle }}">
<meta property="og:description" content="{{ $seoDescription }}">
@if($seoSocialImage)
<meta property="og:image" content="{{ asset('storage/' . $seoSocialImage) }}">
@endif

<!-- Twitter -->
<meta property="twitter:card" content="summary_large_image">
<meta property="twitter:url" content="{{ url()->current() }}">
<meta property="twitter:title" content="{{ $seoTitle }}">
<meta property="twitter:description" content="{{ $seoDescription }}">
@if($seoSocialImage)
<meta property="twitter:image" content="{{ asset('storage/' . $seoSocialImage) }}">
@endif

<!-- Favicon -->
@if($favicon)
<link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $favicon) }}">
@endif

@stack('meta')

<!-- Google Analytics -->
@if($gaId)
<script async src="https://www.googletagmanager.com/gtag/js?id={{ $gaId }}"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', '{{ $gaId }}');
</script>
@endif

<!-- Google Tag Manager -->
@if($gtmId)
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;var f=d.getElementsByTagName(s)[0];
f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','{{ $gtmId }}');</script>
@endif

<!-- Meta Pixel -->
@php $pixelId = $websiteService->getMetaPixelId(); @endphp
@if($pixelId)
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!1;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!1;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', '{{ $pixelId }}');
fbq('track', 'PageView');
</script>
@endif

<!-- Custom Header Scripts -->
{!! $customHeaderScripts !!}

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
