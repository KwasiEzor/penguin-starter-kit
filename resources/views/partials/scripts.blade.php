<script data-navigate-once>
    (function () {
        const ThemeManager = {
            init() {
                this.theme = localStorage.theme || 'system';
                this.darkModeMediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

                this.applyTheme();
                this.setupListeners();
            },

            applyTheme() {
                if (this.theme === 'dark') {
                    this.enableDarkMode();
                } else if (this.theme === 'light') {
                    this.disableDarkMode();
                } else {
                    this.darkModeMediaQuery.matches ? this.enableDarkMode() : this.disableDarkMode();
                }
            },

            enableDarkMode() {
                document.documentElement.classList.add('dark');
            },

            disableDarkMode() {
                document.documentElement.classList.remove('dark');
            },

            setupListeners() {
                this.darkModeMediaQuery.addEventListener('change', (e) => {
                    if (localStorage.theme === 'system') {
                        this.applyTheme();
                    }
                });
            },
        };

        ThemeManager.init();
    })();
</script>

@php
    $websiteService = app(\App\Services\WebsiteService::class);
    $gtmId = $websiteService->getGtmId();
    $customFooterScripts = $websiteService->getCustomScriptsFooter();
@endphp

<!-- Google Tag Manager (noscript) -->
@if($gtmId)
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtmId }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
@endif

<!-- Custom Footer Scripts -->
{!! $customFooterScripts !!}

