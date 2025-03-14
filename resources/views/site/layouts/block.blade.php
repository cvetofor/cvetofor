<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/dist/css/libs.css" rel="stylesheet" />
    <link href="/dist/css/style.css" rel="stylesheet" />
    {!! SEO::generate() !!}
    <link href="/dist/favicon/apple-touch-icon.png" rel="apple-touch-icon" sizes="180x180" />
    <link type="image/png" href="/dist/favicon/favicon-32x32.png" rel="icon" sizes="32x32" />
    <link type="image/png" href="/dist/favicon/favicon-16x16.png" rel="icon" sizes="16x16" />
    <link type="image/svg+xml" href="/dist/favicon.svg" rel="shortcut icon" />
    <link href="/dist/favicon/site.webmanifest" rel="manifest" />
    <link href="/dist/favicon/safari-pinned-tab.svg" rel="mask-icon" color="#81B3D3" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="apple-mobile-web-app-title" content="Template" />
    <meta name="application-name" content="Template" />
    <meta name="msapplication-TileColor" content="#81B3D3" />
    <meta name="theme-color" content="#ffffff" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('styles')
</head>

<body>
    <main class="main">
        @yield('content')
    </main>

    <script src="/dist/js/libs.js"></script>
    <script src="/dist/js/common.js"></script>
    <script src="/dist/js/scripts.js"></script>
    <script src="/dist/js/backend-temp.js"></script>
    <script src="/dist/js/dev-temp.js"></script>
</body>

</html>
