@push('head')
    <link rel="manifest" href="{{ route('platform.resource', ['orchid', 'favicon/manifest.json']) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ route('platform.resource', ['orchid', 'favicon/apple-touch-icon.png']) }}">
    <link rel="shortcut icon" type="image/png" sizes="32x32" href="{{ route('platform.resource', ['orchid', 'favicon/favicon-32x32.png']) }}">
    <link rel="shortcut icon" type="image/png" sizes="16x16" href="{{ route('platform.resource', ['orchid', 'favicon/favicon-16x16.png']) }}">
    <link rel="mask-icon" href="{{ route('platform.resource', ['orchid', 'favicon/safari-pinned-tab.svg']) }}" color="#1a2021">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="application-name" content="ORCHID">
    <meta name="apple-mobile-web-app-title" content="ORCHID">
    <meta name="theme-color" content="#3e4348">
    <meta name="msapplication-navbutton-color" content="#3e4348">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="msapplication-starturl" content="/">
@endpush

<p class="h2 n-m font-thin v-center">
    <i class="icon-orchid"></i>
    <span class="m-l d-none d-sm-block">
        ORCHID
    <small style="
    vertical-align: top;
    opacity: .75;
    ">Platform</small>
    </span>
</p>