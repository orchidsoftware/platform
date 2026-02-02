<!DOCTYPE html>
<html lang="{{  app()->getLocale() }}"
      data-controller="html-load"
      dir="{{ \Orchid\Support\Locale::currentDir() }}"
>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no">
    <title>
        @yield('title', config('app.name'))
        @hasSection('title')
            - {{ config('app.name') }}
        @endif
    </title>
    <meta name="csrf_token" content="{{ csrf_token() }}" id="csrf_token">
    <meta name="auth" content="{{ Auth::check() }}" id="auth">

    {{ Orchid::vite() }}

    @stack('head')

    <meta name="view-transition" content="same-origin">
    <meta name="turbo-root" content="{{  Orchid::prefix() }}">
    <meta name="turbo-refresh-method" content="{{ config('orchid.turbo.refresh-method', 'replace') }}">
    <meta name="turbo-refresh-scroll" content="{{ config('orchid.turbo.refresh-scroll', 'reset') }}">
    <meta name="turbo-prefetch" content="{{ var_export(config('orchid.turbo.prefetch', true)) }}">
    <meta name="dashboard-prefix" content="{{  Orchid::prefix() }}">

    @if(!config('orchid.turbo.cache', false))
        <meta name="turbo-cache-control" content="no-cache">
    @endif

    @foreach(Orchid::getResource('stylesheets') as $stylesheet)
        <link rel="stylesheet" href="{{  $stylesheet }}" data-turbo-track="reload">
    @endforeach

    @stack('stylesheets')

    @foreach(Orchid::getResource('scripts') as $scripts)
        <script src="{{ $scripts }}" defer type="text/javascript" data-turbo-track="reload"></script>
    @endforeach

    @if(!empty(config('orchid.vite', [])))
        @vite(config('orchid.vite'))
    @endif
</head>

<body class="{{ \Orchid\Support\Names::getPageNameClass() }}" data-controller="pull-to-refresh">

<div class="container-fluid" data-controller="@yield('controller')" @yield('controller-data')>

    <div class="row justify-content-center d-md-flex h-100">
        @yield('aside')

        <div class="col-xxl col-lg-9 col-xl-9 col-12 mx-auto">
            @yield('body')
        </div>
    </div>

    @include('orchid::partials.toast')
</div>

@stack('scripts')

@include('orchid::partials.search.modal')
</body>
</html>
