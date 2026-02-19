<script>
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
