<!DOCTYPE html>
<html lang="{{  app()->getLocale() }}" data-controller="html-load" dir="{{ \Orchid\Support\Locale::currentDir() }}">
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
    <meta name="csrf_token" content="{{  csrf_token() }}" id="csrf_token">
    <meta name="auth" content="{{  Auth::check() }}" id="auth">
    @if(\Orchid\Support\Locale::currentDir(app()->getLocale()) == "rtl")
        <link rel="stylesheet" type="text/css" href="{{  mix('/css/orchid.rtl.css','vendor/orchid') }}">
    @else
        <link rel="stylesheet" type="text/css" href="{{  mix('/css/orchid.css','vendor/orchid') }}">
    @endif

    @stack('head')

    <meta name="turbo-root" content="{{  Dashboard::prefix() }}">
    <meta name="dashboard-prefix" content="{{  Dashboard::prefix() }}">

    @if(!config('platform.turbo.cache', false))
        <meta name="turbo-cache-control" content="no-cache">
    @endif

    <script src="{{ mix('/js/manifest.js','vendor/orchid') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/vendor.js','vendor/orchid') }}" type="text/javascript"></script>
    <script src="{{ mix('/js/orchid.js','vendor/orchid') }}" type="text/javascript"></script>

    @foreach(Dashboard::getResource('stylesheets') as $stylesheet)
        <link rel="stylesheet" href="{{  $stylesheet }}">
    @endforeach

    @stack('stylesheets')

    @foreach(Dashboard::getResource('scripts') as $scripts)
        <script src="{{  $scripts }}" defer type="text/javascript"></script>
    @endforeach
</head>

<body class="{{ \Orchid\Support\Names::getPageNameClass() }}" data-controller="pull-to-refresh">

{{--
<div class="container-fluid" data-controller="@yield('controller')" @yield('controller-data')>

    <div class="row">
        @yield('body-left')

        <div class="col min-vh-100 overflow-hidden">
            <div class="d-flex flex-column-fluid">
                <div class="container-md h-full px-0 px-md-5">
                    @yield('body-right')
                </div>
            </div>
        </div>
    </div>


    @include('platform::partials.toast')
</div>
--}}

<header class="mb-5 border-bottom bg-dark shadow-sm">
    <div class="container">
        <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">

            <a class="header-brand order-first" href="{{route('platform.index')}}">
                @includeFirst([config('platform.template.header'), 'platform::header'])
            </a>

            <ul class="nav col-12 col-lg-auto m-lg-auto justify-content-center mb-md-0">
                {!! Dashboard::renderMenu(\Orchid\Platform\Dashboard::MENU_MAIN) !!}
            </ul>

            <div class="">
                @includeWhen(Auth::check(), 'platform::partials.profile')
            </div>
        </div>
    </div>
</header>

<div class="container-fluid" data-controller="@yield('controller')" @yield('controller-data')>

    <div class="row">



        <div class="col overflow-hidden">


            <div class="d-flex flex-column-fluid">

                <div class="container">
                    <div class="col-md-8 mx-auto">

                        <div class="mx-5">
                            <div class="mx-5 bg-white rounded-top shadow-sm border-bottom" style="background-color: rgb(255 255 255 / 90%)!important">
                            @if(Breadcrumbs::has())
                                <nav class="d-flex" aria-label="breadcrumb">
                                    <ol class="breadcrumb mb-0 p-3 mx-auto">
                                        <x-tabuna-breadcrumbs
                                            class="breadcrumb-item"
                                            active="active"
                                        />
                                    </ol>
                                </nav>
                            @endif

                        </div>
                        </div>

                        <div class="bg-white rounded-top shadow-sm min-vh-100">
                            @yield('body-right')
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('platform::partials.toast')
</div>



@stack('scripts')


</body>
</html>
