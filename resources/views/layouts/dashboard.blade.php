<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - ORCHID</title>
    <meta name="csrf_token" content="{{csrf_token()}}">
    <meta name="auth" content="{{Auth::check()}}">
    <link rel="stylesheet" type="text/css" href="{{mix('/css/orchid.css','orchid')}}">

    <link rel="apple-touch-icon" sizes="180x180" href="/orchid/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/orchid/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/orchid/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/orchid/manifest.json">
    <link rel="mask-icon" href="/orchid/safari-pinned-tab.svg" color="#ac5ca0">
    <meta name="theme-color" content="#f8f9fa">

    <meta name="turbolinks-root" content="/{{Dashboard::prefix()}}">
    <meta name="dashboard-prefix" content="{{Dashboard::prefix()}}">

    <meta http-equiv="X-DNS-Prefetch-Control" content="on"/>
    <link rel="dns-prefetch" href="{{ config('app.url') }}"/>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com"/>


    @foreach(Dashboard::getProperty('resources')['stylesheets'] as $stylesheet)
        <link rel="stylesheet" href="{{$stylesheet}}">
    @endforeach

    @stack('stylesheets')


    <script src="{{ mix('/js/orchid.js','orchid')}}" type="text/javascript"></script>
</head>


<body>
<div id="app" class="app app-aside-fixed">

    <!-- header  -->
    <header id="header" class="app-header navbar" role="menu">
        <!-- navbar header  -->
        <div class="navbar-header bg-black dk">

            <button class="pull-right visible-xs"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                <i class="icon-logout"></i>
            </button>

            {{--
            <button class="pull-right visible-xs click"
                    data-turbolinks="false"
                    data-toggle="open"
                    title="Notifications"
                    data-target="#quickview">
                <i class="icon-bell"></i>
            </button>
            --}}

            <button class="pull-right visible-xs click" data-toggle="open" title="Menu" data-target="#aside">
                <i class="icon-menu"></i>
            </button>
            <!-- brand  -->
            <a href="{{route('dashboard.index')}}" class="navbar-brand text-lt">
                <img src="{{asset('/orchid/img/logo.svg')}}" width="50px">
            </a>
            <!-- / brand  -->
        </div>
        <!-- / navbar header  -->

        <!-- navbar collapse  -->
        <div class="app-header wrapper navbar-collapse box-shadow bg-white-only v-center">

            <div class="col-xs-12 col-md-6">
                <h1 class="m-n font-thin h3 text-black">@yield('title')</h1>
                <small class="text-muted text-ellipsis">@yield('description')</small>
            </div>

            <div class="col-xs-12 col-md-6">
                @yield('navbar')
            </div>


        </div>
        <!-- / navbar collapse  -->
    </header>
    <!-- / header  -->


    <!-- aside  -->
    <aside id="aside" class="app-aside hidden-xs">
        <div class="aside-wrap-main">

            <div class="navi-wrap">

                <!-- nav  -->
                <nav class="navi clearfix">
                    <ul class="nav" role="tablist">

                        <li>
                            <a href="/{{Dashboard::prefix()}}" class="navbar-brand text-lt w-full">
                                <img src="/orchid/img/logo.svg" width="50px">
                            </a>
                        </li>

                        {!! Dashboard::menu()->render('Main') !!}

                    </ul>

                    <ul class="nav-footer-fix">
                        <li>
                            <a href="{{ route('dashboard.logout') }}"
                               onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                              <i class="icon-logout" aria-hidden="true"></i>
                            </a>

                            <form id="logout-form" class="hidden" action="{{ route('dashboard.logout') }}" method="POST">
                                {{ csrf_field() }}
                            </form>
                        </li>
                         <li>
                             <a href="{{route('dashboard.systems.cache')}}">
                                 <i class="icon-settings" aria-hidden="true"></i>
                             </a>
                         </li>

                    </ul>

                </nav>
                <!-- nav  -->
            </div>


        </div>

        <div class="aside-wrap">
            <div class="navi-wrap">

                <!-- nav  -->
                <nav class="navi clearfix">
                    <ul class="nav tab-content" id="aside-wrap-list">
                        @include('dashboard::partials.notifications')
                        {!! Dashboard::menu()->render('Main','dashboard::partials.leftSubMenu') !!}
                    </ul>
                </nav>
                <!-- nav  -->


            </div>
        </div>


    </aside>
    <!-- / aside  -->


    <!-- content  -->
    <div id="content" class="app-content" role="main">
        <div class="app-content-body" id="app-content-body">

            @include('dashboard::partials.alert')

            @if (count($errors) > 0)
                <div class="alert alert-danger m-b-none" role="alert">
                    <strong>Oh snap!</strong>
                    Change a few things up and try submitting again.
                    <ul class="m-t-xs">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            @yield('content')
        </div>
    </div>
    <!-- /content  -->

</div>
<div id="dashboard-alerts"></div>



@foreach(Dashboard::getProperty('resources')['scripts'] as $scripts)
    <script src="{{$scripts}}" type="text/javascript"></script>
@endforeach

@stack('scripts')

<script>
    var activeMenu = false;
    $('#aside-wrap-list').children('.tab-pane').each(function () {
        if($(this).hasClass('active')){
           activeMenu = true;
        }
    });

    if(!activeMenu){
        $('#menu-notifications').addClass('active')
    }

</script>



</body>
</html>
