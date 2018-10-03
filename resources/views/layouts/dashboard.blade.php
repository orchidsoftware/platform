@extends('platform::layouts.app')


@section('body')


    <style>

        .app:before {
            /*background-color: #efeff0;*/
            background: rgba(60,65,70,1);
            background: -moz-linear-gradient(left, rgba(60,65,70,1) 0%, rgba(60,65,70,1) 50%, rgba(255,255,255,1) 51%, rgba(255,255,255,1) 71%, rgba(255,255,255,1) 100%);
            background: -webkit-gradient(left top, right top, color-stop(0%, rgba(60,65,70,1)), color-stop(50%, rgba(60,65,70,1)), color-stop(51%, rgba(255,255,255,1)), color-stop(71%, rgba(255,255,255,1)), color-stop(100%, rgba(255,255,255,1)));
            background: -webkit-linear-gradient(left, rgba(60,65,70,1) 0%, rgba(60,65,70,1) 50%, rgba(255,255,255,1) 51%, rgba(255,255,255,1) 71%, rgba(255,255,255,1) 100%);
            background: -o-linear-gradient(left, rgba(60,65,70,1) 0%, rgba(60,65,70,1) 50%, rgba(255,255,255,1) 51%, rgba(255,255,255,1) 71%, rgba(255,255,255,1) 100%);
            background: -ms-linear-gradient(left, rgba(60,65,70,1) 0%, rgba(60,65,70,1) 50%, rgba(255,255,255,1) 51%, rgba(255,255,255,1) 71%, rgba(255,255,255,1) 100%);
            background: linear-gradient(to right, rgba(60,65,70,1) 0%, rgba(60,65,70,1) 50%, rgba(255,255,255,1) 51%, rgba(255,255,255,1) 71%, rgba(255,255,255,1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#3c4146', endColorstr='#ffffff', GradientType=1 );
        }

        .bg-dark{
            background-color: rgba(60,65,70,1)!important;
        }

    </style>

    <div class="app row m-n" id="app" data-controller="@yield('controller')">


        <div class="col-md-2 offset-md-2 no-padder bg-dark" style="
    max-width: 250px;
">

            <div class="d-flex v-center wrapper mt-4">
                    <a class="header-brand" href="{{route('platform.index')}}">
                        <p class="h2 n-m font-thin v-center">
                            <img ng-src="//www.gstatic.com/analytics-suite/header/legacy/v2/ic_analytics.svg"
                                 alt="Google&nbsp;Аналитика" class="ng-scope"
                                 src="//www.gstatic.com/analytics-suite/header/legacy/v2/ic_analytics.svg"
                                 style="
max-width: 33px;
">
                            <span class="m-l d-none d-sm-block">
Google
<small style="
vertical-align: top;
opacity: .75;
">Аналитика</small>
</span>
                        </p>
                    </a>


                    <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse"
                       data-target="#headerMenuCollapse">
                        <span class="header-toggler-icon icon-menu"></span>
                    </a>
                </div>

            @include('platform::partials.search')

            {{--
                @include('platform::partials.notifications')
            --}}

            <div class="wrapper">
                <div class="dropdown">
                <a href="#" class="nav-link p-0 v-center" data-toggle="dropdown">
                    <span class="thumb-sm avatar m-r-xs">
                        <img src="{{Auth::user()->getAvatar()}}" class="b bg-light" alt="test">
                    </span>
                    <span class="ml-2 d-none d-lg-block" style="max-width:150px;font-size: 0.82857rem;">
                        <span class="text-ellipsis">{{Auth::user()->getNameTitle()}}</span>
                        <span class="text-muted d-block text-ellipsis">{{Auth::user()->getSubTitle()}}</span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow">
                    {!! Dashboard::menu()->render('Profile','platform::partials.dropdownMenu') !!}

                    <div class="dropdown-divider"></div>

                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#support">
                        <i class="m-r-xs icon-help"></i> Need help?
                    </a>

                    @if(Auth::user()->hasAccess('platform.systems.index'))
                        <a href="{{ route('platform.systems.index') }}" class="dropdown-item">
                            <i class="icon-settings m-r-xs" aria-hidden="true"></i>
                            <span>{{trans('platform::menu.systems')}}</span>
                        </a>
                    @endif

                    @if(session()->has('original_user'))
                        <a href="{{route('platform.systems.users')}}"
                           class="dropdown-item"
                           onclick="event.preventDefault();document.getElementById('return-original-user').submit();"
                        >
                            <i class="icon-logout m-r-xs" aria-hidden="true"></i>
                            <span>Вернуться в свой аккаунт</span>
                        </a>
                        <form id="return-original-user" class="hidden"
                              action="{{ route('platform.systems.users.edit',[Auth::user(),'switchUserStop']) }}"
                              method="POST">
                            @csrf
                        </form>
                    @else
                        <a href="{{ route('platform.logout') }}"
                           class="dropdown-item"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                           dusk="logout-button">
                            <i class="icon-logout m-r-xs" aria-hidden="true"></i>
                            <span>{{trans('platform::auth/account.sign_out')}}</span>
                        </a>
                        <form id="logout-form" class="hidden" action="{{ route('platform.logout') }}"
                              method="POST">
                            @csrf
                        </form>
                    @endif

                </div>
            </div>
            </div>

            <div class="sidebar-sticky">
                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
                    <span class="hidden-folded padder m-t-xs m-b-xs text-muted text-xs">Optimized for UI like</span>

                </h6>
                <ul class="nav flex-column">

                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="icon-home m-r-xs text-lg"></i>
                                                                Dashboard <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="icon-notebook m-r-xs text-lg"></i>
                            Orders
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="icon-bar-chart m-r-xs text-lg"></i>
                            <span>Products</span>
                            <span class="float-right">
    <b class="badge bg-primary">6</b>
</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="icon-people text-lg" style="
width: 20px;
overflow: hidden;
"> </i>
                            Customers
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="icon-bag  m-r-xs text-lg"></i>
                            Reports
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="icon-folder m-r-xs text-lg"></i>
                            Integrations
                        </a>
                    </li>
                </ul>

                <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                    <span class="hidden-folded padder m-t-xs m-b-xs text-muted text-xs">Saved reports</span>
                    <a class="d-flex align-items-center" href="#">
                        <i class="icon-plus text-md"></i>
                    </a>
                </h6>
                <ul class="nav flex-column mb-2">
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="icon-paste  m-r-xs text-lg"></i>
                            Current month
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="icon-paste  m-r-xs text-lg"></i>

                            Last quarter
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="icon-paste  m-r-xs text-lg"></i>
                            Social engagement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="icon-paste  m-r-xs text-lg"></i>
                            Year-end sale
                        </a>
                    </li>
                </ul>
            </div>


            <div class="padder-v m-b m-t">

                <div class=" text-center">
                    <p class="small m-n">
                        © 2016 - {{date('Y')}} The application code is published under the MIT license.<br>
                        Currently v{{\Orchid\Platform\Dashboard::VERSION}}.
                    </p>
                </div>
            </div>

        </div>
        <div class="col-md-6 bg-white b-l b-r box-shadow-lg no-padder">


            <div class="wrapper-lg">

                <div class="v-center">
                    <div class="col-xs-12 col-md-4 no-padder">
                        <h1 class="m-n font-thin h3 text-black">@yield('title')</h1>
                        <small class="text-muted text-ellipsis">@yield('description')</small>
                    </div>
                    <div class="col-xs-12 col-md-8 no-padder">
                        @yield('navbar')
                    </div>
                </div>

                @if (Breadcrumbs::exists())
                    {{ Breadcrumbs::view('platform::partials.breadcrumbs') }}
                @endif
            </div>


            <div class="d-flex">
                <div class="app-content-body" id="app-content-body">
                    @include('platform::partials.alert')
                    @yield('content')
                </div>
            </div>

        </div>
    </div>

@endsection