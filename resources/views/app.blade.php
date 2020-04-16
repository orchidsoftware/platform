<!DOCTYPE html>
<html lang="{{  app()->getLocale() }}" data-controller="layouts--html-load">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title','ORCHID') - @yield('description','Admin')</title>
    <meta name="csrf_token" content="{{  csrf_token() }}" id="csrf_token" data-turbolinks-permanent>
    <meta name="auth" content="{{  Auth::check() }}"  id="auth" data-turbolinks-permanent>
    @if(file_exists(public_path('/css/orchid/orchid.css')))
        <link rel="stylesheet" type="text/css" href="{{  mix('/css/orchid/orchid.css') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{  orchid_mix('/css/orchid.css','orchid') }}">
    @endif

    @stack('head')

    <meta name="turbolinks-root" content="{{  Dashboard::prefix() }}">
    <meta name="dashboard-prefix" content="{{  Dashboard::prefix() }}">

    <script src="{{ orchid_mix('/js/manifest.js','orchid') }}" type="text/javascript"></script>
    <script src="{{ orchid_mix('/js/vendor.js','orchid') }}" type="text/javascript"></script>
    <script src="{{ orchid_mix('/js/orchid.js','orchid') }}" type="text/javascript"></script>

    @foreach(Dashboard::getResource('stylesheets') as $stylesheet)
        <link rel="stylesheet" href="{{  $stylesheet }}">
    @endforeach

    @stack('stylesheets')

    @foreach(Dashboard::getResource('scripts') as $scripts)
        <script src="{{  $scripts }}" defer type="text/javascript"></script>
    @endforeach
</head>

<body>


<div class="app row m-n" id="app" data-controller="@yield('controller')" @yield('controller-data')>
    <div class="container-lg">
        <div class="row">
            <div class="aside col-xs-12 col-md-2 offset-xxl-0 col-xl-2 col-xxl-3 no-padder bg-dark">
                <div class="d-md-flex align-items-start flex-column d-sm-block h-full">
                    @yield('body-left')
                </div>
            </div>
            <div class="col-md col-xl col-xxl-9 bg-white shadow no-padder min-vh-100 overflow-hidden">
                @yield('body-right')
            </div>
        </div>
    </div>


@include('platform::partials.toast')
</div>

@stack('scripts')


</body>
</html>
