<!DOCTYPE html>
<html lang="{{app()->getLocale()}}" data-controller="layouts--html-load">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','ORCHID')</title>
    <meta name="csrf_token" content="{{csrf_token()}}">
    <meta name="auth" content="{{Auth::check()}}">
    <link rel="stylesheet" type="text/css" href="{{mix('/css/orchid.css','orchid')}}">

    <link rel="apple-touch-icon" sizes="180x180" href="/orchid/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/orchid/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/orchid/favicon/favicon-16x16.png">
    <link rel="manifest" href="/orchid/favicon/manifest.json">
    <link rel="mask-icon" href="/orchid/favicon/safari-pinned-tab.svg" color="#1a2021">
    <meta name="apple-mobile-web-app-title" content="ORCHID">
    <meta name="application-name" content="ORCHID">
    <meta name="theme-color" content="#ffffff">

    <meta name="turbolinks-root" content="{{Dashboard::prefix()}}">
    <meta name="dashboard-prefix" content="{{Dashboard::prefix()}}">

    <meta http-equiv="X-DNS-Prefetch-Control" content="on"/>
    <link rel="dns-prefetch" href="{{ config('app.url') }}"/>

    <script src="{{ mix('/js/manifest.js','orchid')}}" type="text/javascript"></script>
    <script src="{{ mix('/js/vendor.js','orchid')}}" type="text/javascript"></script>
    <script src="{{ mix('/js/orchid.js','orchid')}}" type="text/javascript"></script>

    @foreach(Dashboard::getResource('stylesheets') as $stylesheet)
        <link rel="stylesheet" href="{{$stylesheet}}">
    @endforeach

    @stack('stylesheets')

    @foreach(Dashboard::getResource('scripts') as $scripts)
        <script src="{{$scripts}}" type="text/javascript"></script>
    @endforeach

</head>

<body>

@yield('body')

@stack('scripts')

</body>
</html>
