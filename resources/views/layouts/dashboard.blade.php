<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - Orchid</title>
    <meta name="csrf_token" content="{{csrf_token()}}">
    <meta name="auth" content="{{Auth::check()}}">
    <link rel="stylesheet" href="/orchid/css/orchid.css">


    <link rel="apple-touch-icon" sizes="180x180" href="/orchid/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/orchid/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/orchid/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/orchid/manifest.json">
    <link rel="mask-icon" href="/orchid/safari-pinned-tab.svg" color="#ac5ca0">
    <meta name="theme-color" content="#f8f9fa">


    <meta http-equiv="X-DNS-Prefetch-Control" content="on"/>
    <link rel="dns-prefetch" href="{{ config('app.url') }}"/>
    <link rel="dns-prefetch" href="https://fonts.googleapis.com"/>


    @foreach(Dashboard::getProperty('resources')['stylesheets'] as $stylesheet)
        <link rel="stylesheet" href="{{$stylesheet}}">
    @endforeach

    @stack('stylesheets')


    <script src="/orchid/js/orchid.js" type="text/javascript"></script>

</head>


<body>
<div id="app" class="app app-aside-fixed">

    <!-- header  -->
    <header id="header" class="app-header navbar" role="menu">
        <!-- navbar header  -->
        <div class="navbar-header bg-black">
            <button class="pull-right visible-xs dk">
                <i class="fa fa-cog"></i>
            </button>
            <button class="pull-right visible-xs">
                <i class="fa fa-bars"></i>
            </button>
            <!-- brand  -->
            <a href="{{route('dashboard.index')}}" class="navbar-brand text-lt">
                <img src="{{asset('/orchid/img/logo.svg')}}" width="50px">
                <!--<span class="hidden-folded m-l-xs">Orchid</span>-->
            </a>
            <!-- / brand  -->
        </div>
        <!-- / navbar header  -->

        <!-- navbar collapse  -->
        <div class="app-header wrapper navbar-collapse box-shadow bg-white-only">

            <div class="col-xs-6">
                <h1 class="m-n font-thin h3 text-black">@yield('title')</h1>
                <small class="text-muted text-ellipsis">@yield('description')</small>
            </div>

        @section('navbar')
            <!-- nabar right  -->
                <ul class="nav navbar-nav navbar-right">

                    <li>
                        <a href="#" class="click" data-toggle="open"  title="Notifications" data-target="#quickview">
                            <i class="icon-bell"></i>
                            <span class="visible-xs-inline">Notifications</span>


                            @php
                                $unreadNotificationsCount = Auth::user()->unreadNotifications->where('type',\Orchid\Platform\Notifications\DashboardNotification::class)->count();
                            @endphp

                            @if($unreadNotificationsCount > 0)
                                <span class="badge badge-sm up bg-danger pull-right-xs">
                                    {{$unreadNotificationsCount}}
                                </span>
                            @endif
                        </a>
                    </li>

                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle clear">

                            {{--
            <span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
            <img src="data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9InllcyI/PjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgdmlld0JveD0iMCAwIDE0MCAxNDAiIHByZXNlcnZlQXNwZWN0UmF0aW89Im5vbmUiPjwhLS0KU291cmNlIFVSTDogaG9sZGVyLmpzLzE0MHgxNDAKQ3JlYXRlZCB3aXRoIEhvbGRlci5qcyAyLjYuMC4KTGVhcm4gbW9yZSBhdCBodHRwOi8vaG9sZGVyanMuY29tCihjKSAyMDEyLTIwMTUgSXZhbiBNYWxvcGluc2t5IC0gaHR0cDovL2ltc2t5LmNvCi0tPjxkZWZzPjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+PCFbQ0RBVEFbI2hvbGRlcl8xNThlZjJlN2ExMSB0ZXh0IHsgZmlsbDojQUFBQUFBO2ZvbnQtd2VpZ2h0OmJvbGQ7Zm9udC1mYW1pbHk6QXJpYWwsIEhlbHZldGljYSwgT3BlbiBTYW5zLCBzYW5zLXNlcmlmLCBtb25vc3BhY2U7Zm9udC1zaXplOjEwcHQgfSBdXT48L3N0eWxlPjwvZGVmcz48ZyBpZD0iaG9sZGVyXzE1OGVmMmU3YTExIj48cmVjdCB3aWR0aD0iMTQwIiBoZWlnaHQ9IjE0MCIgZmlsbD0iI0VFRUVFRSIvPjxnPjx0ZXh0IHg9IjQzLjgxMjUiIHk9Ijc0LjUiPjE0MHgxNDA8L3RleHQ+PC9nPjwvZz48L3N2Zz4=" alt="...">
            <i class="on md b-white bottom"></i>
          </span>
          --}}

                            <span class="">{{Auth::user()->name}}</span>
                            <b class="caret"></b>
                        </a>
                        <!-- dropdown  -->
                        <ul class="dropdown-menu w-full">
                            {{--
                            <li class="wrapper b-b m-b-sm bg-light m-t-n-xs">
                                <div>
                                    <p>300mb из 500mb</p>
                                </div>
                                <div  class="progress progress-xs m-b-none dker">
                                    <div  class="progress-bar progress-bar-info" data-toggle="tooltip"
                                         data-original-title="50%" style="width: 50%"></div>
                                </div>
                            </li>
                            <li>
                                <a href="">
                                    <span class="badge bg-danger pull-right">New/span>
                                    <span>Настройки</span>
                                </a>
                            </li>
                            <li>
                                <a>Профиль</a>
                            </li>
                            <li>
                                <a>
                                    <span class="label bg-info pull-right">новое</span>
                                    Помощь
                                </a>
                            </li>
                            <li class="divider"></li>
                             --}}


                            <li>
                                <a href="{{url(config('app.url'))}}">
                                    <span>{{trans('dashboard::common.website')}}</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('dashboard.systems.users.edit',Auth::user()->id)}}">
                                    <span>{{trans('dashboard::common.profile')}}</span>
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>

                                <a href="{{ url('/dashboard/logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{trans('dashboard::auth/account.sign_out')}}
                                </a>

                                <form id="logout-form" action="{{ url('/dashboard/logout') }}" method="POST"
                                      style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                        <!-- / dropdown  -->
                    </li>


                </ul>
                <!-- / navbar right  -->
            @show


        </div>
        <!-- / navbar collapse  -->
    </header>
    <!-- / header  -->


    <!-- aside  -->
    <aside id="aside" class="app-aside hidden-xs">
        <div class="aside-wrap-main  b-b b-dark">

            <div class="navi-wrap">

                <!-- nav  -->
                <nav class="navi clearfix">
                    <ul class="nav" role="tablist">

                        <li>
                            <a href="/dashboard" class="navbar-brand text-lt w-full">
                                <img src="/orchid/img/logo.svg" width="50px">
                            </a>
                        </li>

                        {!! Dashboard::menu()->render('Main') !!}

                    </ul>

                    <ul class="nav-footer-fix">
                        <li><a href="#"><i class="icon-grid" aria-hidden="true"></i></a></li>
                        <li><a href="{{route('dashboard.systems.cache')}}"><i class="icon-settings" aria-hidden="true"></i></a></li>
                    </ul>

                </nav>
                <!-- nav  -->
            </div>


        </div>

        <div class="aside-wrap">
            <div class="navi-wrap">

                <!-- nav  -->
                <nav class="navi clearfix">
                    <ul class="nav b-b b-dark tab-content">
                        {!! Dashboard::menu()->render('Main','dashboard::partials.leftSubMenu') !!}
                    </ul>
                </nav>
                <!-- nav  -->

                {{-- To do:
                <!-- aside footer  -->
                <div  class="wrapper m-t">

                    <div  class="text-center-folded">
                        <span class="pull-right pull-none-folded">60%</span>
                        <span class="hidden-folded">Закрытых заказов</span>
                    </div>
                    <div  class="progress progress-xxs m-t-sm lter">
                        <div  class="progress-bar progress-bar-info" style="width: 60%;">
                        </div>
                    </div>
                    <div  class="text-center-folded">
                        <span class="pull-right pull-none-folded">35%</span>
                        <span class="hidden-folded">Заказов в процессе</span>
                    </div>
                    <div  class="progress progress-xxs m-t-sm lter">
                        <div  class="progress-bar progress-bar-primary" style="width: 35%;">
                        </div>
                    </div>
                </div>
                <!-- / aside footer  -->
                --}}


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

    <!-- footer  -->
    <footer id="footer" class="app-footer" role="footer">
        <div class="wrapper b-t bg-light">
            <span class="pull-right">{{ App::version() }}/{{ Dashboard::version() }}
                <a href="https://github.com/TheOrchid/Platform" class="m-l-sm text-muted"> <i class="fa fa-github"></i></a>
            </span>
            © {{date("Y")}} Copyright.
        </div>
    </footer>
    <!-- / footer  -->
</div>


@include('dashboard::partials.quick')




@foreach(Dashboard::getProperty('resources')['scripts'] as $scripts)
    <script src="{{$scripts}}" type="text/javascript"></script>
@endforeach

@stack('scripts')

</body>
</html>
