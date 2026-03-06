<!doctype html>
<html lang="en" data-theme="{{ $config->get('ui.theme', 'light') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="color-scheme" content="{{ $config->get('ui.theme', 'light') }}">
    <title>{{ $config->get('ui.title') ?? config('app.name') . ' - API Docs' }}</title>

    <script src="https://unpkg.com/@stoplight/elements@8.4.2/web-components.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/@stoplight/elements@8.4.2/styles.min.css">

    <script>
        const originalFetch = window.fetch;

        // intercept TryIt requests and add headers
        window.fetch = (url, options) => {
            const getCookieValue = (key) => {
                const cookie = document.cookie.split(';').find((cookie) => cookie.trim().startsWith(key));
                return cookie?.split("=")[1];
            };

            const updateFetchHeaders = (headers, headerKey, headerValue) => {
                if (headers instanceof Headers) {
                    headers.set(headerKey, headerValue);
                } else if (Array.isArray(headers)) {
                    headers.push([headerKey, headerValue]);
                } else if (headers) {
                    headers[headerKey] = headerValue;
                }
            };

            const { headers = new Headers() } = options || {};

            // Add CSRF for Sanctum stateful auth if cookie exists
            const csrfToken = getCookieValue("XSRF-TOKEN");
            if (csrfToken) {
                updateFetchHeaders(headers, "X-XSRF-TOKEN", decodeURIComponent(csrfToken));
            }

            // Add Bearer token from localStorage for Sanctum stateless auth
            const apiToken = localStorage.getItem('penguin_api_token');
            if (apiToken) {
                updateFetchHeaders(headers, "Authorization", `Bearer ${apiToken}`);
            }

            return originalFetch(url, { ...options, headers });
        };
    </script>

    <style>
        html, body { margin:0; height:100%; }
        body { background-color: var(--color-canvas); }
        
        /* Auth Drawer */
        .auth-drawer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: #1e293b;
            color: white;
            transition: transform 0.3s ease-in-out;
            box-shadow: 0 -4px 20px rgba(0,0,0,0.2);
            font-family: ui-sans-serif, system-ui, sans-serif;
            transform: translateY(calc(100% - 40px)); /* Initially collapsed */
        }
        .auth-drawer.open {
            transform: translateY(0);
        }
        .auth-drawer-header {
            height: 40px;
            padding: 0 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
            background: #0f172a;
        }
        .auth-drawer-content {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .auth-label { font-size: 13px; font-weight: 700; color: #3b82f6; display: flex; align-items: center; gap: 8px; }
        .auth-drawer-content input {
            background: #334155;
            border: 1px solid #475569;
            color: white;
            padding: 10px 12px;
            border-radius: 6px;
            width: 100%;
            box-sizing: border-box;
            font-size: 14px;
            outline: none;
        }
        .auth-drawer-content input:focus { border-color: #3b82f6; }
        .auth-actions { display: flex; gap: 10px; }
        .auth-actions button {
            flex: 1;
            padding: 10px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            border: none;
            transition: all 0.2s;
        }
        .btn-save { background: #3b82f6; color: white; }
        .btn-save:hover { background: #2563eb; }
        .btn-clear { background: transparent; color: #94a3b8; border: 1px solid #475569 !important; }
        .btn-clear:hover { background: rgba(255,255,255,0.05); color: white; }
        
        .toggle-icon { transition: transform 0.3s; }
        .open .toggle-icon { transform: rotate(180deg); }

        /* elements styling */
        [data-theme="dark"] .token.property { color: rgb(128, 203, 196) !important; }
        [data-theme="dark"] .token.operator { color: rgb(255, 123, 114) !important; }
        [data-theme="dark"] .token.number { color: rgb(247, 140, 108) !important; }
        [data-theme="dark"] .token.string { color: rgb(165, 214, 255) !important; }
        [data-theme="dark"] .token.boolean { color: rgb(121, 192, 255) !important; }
        [data-theme="dark"] .token.punctuation { color: #dbdbdb !important; }
    </style>
</head>
<body style="height: 100vh; overflow-y: hidden">

<div id="auth-drawer" class="auth-drawer">
    <div class="auth-drawer-header" onclick="toggleAuthDrawer()">
        <span class="auth-label">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" style="width: 16px; height: 16px;">
                <path fill-rule="evenodd" d="M10 1a4.5 4.5 0 00-4.5 4.5V9H5a2 2 0 00-2 2v6a2 2 0 002 2h10a2 2 0 002-2v-6a2 2 0 00-2-2h-.5V5.5A4.5 4.5 0 0010 1zm3 8V5.5a3 3 0 10-6 0V9h6z" clip-rule="evenodd" />
            </svg>
            API AUTHENTICATION
        </span>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="toggle-icon" style="width: 20px; height: 20px;">
            <path fill-rule="evenodd" d="M14.77 12.79a.75.75 0 01-1.06-.02L10 8.832 6.29 12.77a.75.75 0 11-1.08-1.04l4.25-4.5a.75.75 0 011.08 0l4.25 4.5a.75.75 0 01-.02 1.06z" clip-rule="evenodd" />
        </svg>
    </div>
    <div class="auth-drawer-content">
        <p style="font-size: 12px; color: #94a3b8; margin: 0 0 5px 0;">Your Sanctum token will be saved in your browser and automatically included in all "Try It" requests.</p>
        <input type="password" id="api-token-field" placeholder="Paste your Bearer token here...">
        <div class="auth-actions">
            <button class="btn-save" onclick="saveToken()">Save & Apply</button>
            <button class="btn-clear" onclick="clearToken()">Clear</button>
        </div>
    </div>
</div>

<elements-api
    id="docs"
    tryItCredentialsPolicy="{{ $config->get('ui.try_it_credentials_policy', 'include') }}"
    router="hash"
    @if($config->get('ui.hide_try_it')) hideTryIt="true" @endif
    @if($config->get('ui.hide_schemas')) hideSchemas="true" @endif
    @if($config->get('ui.logo')) logo="{{ $config->get('ui.logo') }}" @endif
    @if($config->get('ui.layout')) layout="{{ $config->get('ui.layout') }}" @endif
/>

<script>
    function toggleAuthDrawer() {
        document.getElementById('auth-drawer').classList.toggle('open');
    }

    function saveToken() {
        const val = document.getElementById('api-token-field').value;
        if (val) {
            localStorage.setItem('penguin_api_token', val);
            toggleAuthDrawer();
            alert('API Token saved! Headers will be updated automatically.');
        }
    }

    function clearToken() {
        localStorage.removeItem('penguin_api_token');
        document.getElementById('api-token-field').value = '';
        alert('Token cleared.');
    }

    window.addEventListener('load', () => {
        const token = localStorage.getItem('penguin_api_token');
        if (token) {
            document.getElementById('api-token-field').value = token;
        }
    });

    (async () => {
        const docs = document.getElementById('docs');
        docs.apiDescriptionDocument = @json($spec);
    })();
</script>

@if($config->get('ui.theme', 'light') === 'system')
    <script>
        var mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

        function updateTheme(e) {
            if (e.matches) {
                window.document.documentElement.setAttribute('data-theme', 'dark');
                window.document.getElementsByName('color-scheme')[0].setAttribute('content', 'dark');
            } else {
                window.document.documentElement.setAttribute('data-theme', 'light');
                window.document.getElementsByName('color-scheme')[0].setAttribute('content', 'light');
            }
        }

        mediaQuery.addEventListener('change', updateTheme);
        updateTheme(mediaQuery);
    </script>
@endif
</body>
</html>
