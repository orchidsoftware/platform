@extends('platform::layouts.app')


@section('body')


    <style>

        .app:before {
            background-color: #efeff0;
        }

    </style>

    <div class="app row m-n" id="app" data-controller="@yield('controller')">


        <div class="col-md-2 offset-md-2 no-padder bg-grey" style="
    max-width: 250px;
">

            <div style="
">

                <div style="
">
                    <div>

                        <div class="d-flex v-center wrapper mt-4">
                            <a class="header-brand" href="http://localhost:8000/dashboard">
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

                    </div>

                    <div class="wrapper">
                        <div class="input-icon">
                            <input data-action="keyup->layouts--systems#filter" type="text"
                                   class="form-control input-sm  no-border rounded padder" placeholder="Search ...">
                            <div class="input-icon-addon">
                                <i class="icon-magnifier"></i>
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
                            <a class="d-flex align-items-center text-muted" href="#">
                                <i class="icon-plus text-black text-md"></i>
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
                </div>
            </div>

        </div>
        <div class="col-md-6 bg-white b-l b-r no-padder">


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