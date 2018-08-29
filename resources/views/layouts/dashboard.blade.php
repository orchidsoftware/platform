@extends('platform::layouts.app')


@section('body')

<div id="app" class="app" data-controller="@yield('controller')">



    {{--
    <!-- aside  -->
    <aside id="aside" class="app-aside d-none d-md-block" data-controller="layouts--left-menu">
        <div class="aside-wrap-main">

            <div class="navi-wrap">

                <!-- nav  -->
                <nav class="navi clearfix">
                    <ul class="nav flex-column" role="tablist">


                        <li class="nav-item">
                            <a href="{{route('platform.index')}}" class="navbar-brand nav-link text-lt w-full">
                                <i class="icon-orchid text-primary" style="font-size: 2rem"></i>
                            </a>
                        </li>


                        <li role="presentation" class="nav-item">
                            <a href="#globalSearch" id="globalSearch-tab" class="nav-link" role="tab" data-toggle="tab">
                                <i class="icon-magnifier"></i>
                                <span>Поиск</span>
                            </a>
                        </li>


                        {!! Dashboard::menu()->render('Main') !!}

                    </ul>

                    <ul class="nav nav-footer-fix">
                        @if(Auth::user()->hasAccess('platform.systems.index'))
                            <li>
                                <a href="{{ route('platform.systems.index') }}">
                                    <i class="icon-settings" aria-hidden="true"></i>
                                    <span>{{trans('platform::menu.systems')}}</span>
                                </a>
                            </li>
                        @endif

                        <li>
                            <a href="{{ route('platform.logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                               dusk="logout-button">
                                <i class="icon-logout" aria-hidden="true"></i>
                                <span>{{trans('platform::auth/account.sign_out')}}</span>
                            </a>

                            <form id="logout-form" class="hidden" action="{{ route('platform.logout') }}"
                                  method="POST">
                                @csrf
                            </form>
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

                    <div class="nav tab-content flex-column" id="aside-wrap-list">

                        <div class="w-full tab-pane fade in nav show"
                             role="tabpanel"
                             id="menu-default"
                             aria-labelledby="notise-tab">
                            @yield('aside', View::make('platform::partials.notifications'))
                        </div>

                        <div class="w-full tab-pane fade in nav show"
                             role="tabpanel"
                             id="globalSearch"
                             aria-labelledby="globalSearch-tab">

                            <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">Глобальный поиск</li>
                            <form role="search">
                                <div class="form-group b-b b-dark">
                                    <div class="input-group">
                                        <input type="text" class="form-control input-sm bg-black text-white no-border rounded padder" placeholder="Search projects..."
                                        style="background: #222c3c!important">
                                    </div>
                                </div>
                            </form>

                        </div>

                        {!! Dashboard::menu()->render('Main','platform::partials.leftSubMenu') !!}
                    </div>
                </nav>
                <!-- nav  -->

            </div>
        </div>


    </aside>
    <!-- / aside  -->
    --}}


    <aside id="aside" class="app-aside hidden-xs bg-dark">
        <div class="aside-wrap">
            <div class="navi-wrap">

                <!-- user -->
                <div class="clearfix hidden-xs text-center hide">

                    <div class="nav-item">
                        <a href="{{route('platform.index')}}" class="navbar-brand nav-link no-padder m-0 text-lt w-full">
                            <i class="icon-orchid text-primary" style="font-size: 2rem"></i>
                        </a>
                    </div>

                    <div class="line dk hidden-folded"></div>
                </div>
                <!-- / user -->

                @php

                    $user = Auth::user();

    $user->notify(new \Orchid\Platform\Notifications\DashboardNotification([
        'title' => 'Hello Word',
        'message' => 'New post!',
        'action' => 'https://google.com',
        'type' => 'error',
    ]));

                @endphp

                <!-- nav -->
                <nav class="navi clearfix">
                    <ul class="nav">

                        @include('platform::partials.notifications')

                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span>Navigation</span>
                        </li>
                        <li>
                            <a href="" class="auto">
                  <span class="pull-right text-muted">
                    <i class="icon-arrow-right text"></i>
                    <i class="icon-arrow-down text-active"></i>
                  </span>
                                <i class="glyphicon glyphicon-stats icon text-primary-dker"></i>
                                <span class="font-bold">Dashboard</span>
                            </a>
                            <ul class="nav nav-sub dk">
                                <li class="nav-sub-header">
                                    <a href="">
                                        <span>Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="index.html">
                                        <span>Dashboard v1</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="dashboard.html">
                                        <b class="label bg-info pull-right">N</b>
                                        <span>Dashboard v2</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="mail.html">
                                <b class="badge bg-info pull-right">9</b>
                                <i class="glyphicon glyphicon-envelope icon text-info-lter"></i>
                                <span class="font-bold">Email</span>
                            </a>
                        </li>
                        <li class="line dk"></li>

                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span>Components</span>
                        </li>
                        <li class="active">
                            <a href="" class="auto">
                  <span class="pull-right text-muted">
                    <i class="icon-arrow-right text"></i>
                    <i class="icon-arrow-down text-active"></i>
                  </span>
                                <b class="badge bg-info pull-right">3</b>
                                <i class="glyphicon glyphicon-th"></i>
                                <span>Layout</span>
                            </a>
                            <ul class="nav nav-sub dk" style="">
                                <li class="nav-sub-header">
                                    <a href="">
                                        <span>Layout</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="layout_app.html">
                                        <span>Application</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="layout_fullwidth.html">
                                        <span>Full width</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="layout_boxed.html">
                                        <span>Boxed layout</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="" class="auto">
                  <span class="pull-right text-muted">
                    <i class="icon-arrow-right text"></i>
                    <i class="icon-arrow-down text-active"></i>
                  </span>
                                <i class="glyphicon glyphicon-briefcase icon"></i>
                                <span>UI Kits</span>
                            </a>
                            <ul class="nav nav-sub dk">
                                <li class="nav-sub-header">
                                    <a href="">
                                        <span>UI Kits</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="ui_button.html">
                                        <span>Buttons</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="ui_icon.html">
                                        <b class="badge bg-info pull-right">3</b>
                                        <span>Icons</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="ui_grid.html">
                                        <span>Grid</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="ui_widget.html">
                                        <b class="badge bg-success pull-right">13</b>
                                        <span>Widgets</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="ui_sortable.html">
                                        <span>Sortable</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="ui_portlet.html">
                                        <span>Portlet</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="ui_timeline.html">
                                        <span>Timeline</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="ui_jvectormap.html">
                                        <span>Vector Map</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="" class="auto">
                  <span class="pull-right text-muted">
                    <i class="icon-arrow-right text"></i>
                    <i class="icon-arrow-down text-active"></i>
                  </span>
                                <b class="label bg-primary pull-right">2</b>
                                <i class="glyphicon glyphicon-list"></i>
                                <span>Table</span>
                            </a>
                            <ul class="nav nav-sub dk">
                                <li class="nav-sub-header">
                                    <a href="">
                                        <span>Table</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="table_static.html">
                                        <span>Table static</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="table_datatable.html">
                                        <span>Datatable</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="table_footable.html">
                                        <span>Footable</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="" class="auto">
                  <span class="pull-right text-muted">
                    <i class="icon-arrow-right text"></i>
                    <i class="icon-arrow-down text-active"></i>
                  </span>
                                <i class="glyphicon glyphicon-edit"></i>
                                <span>Form</span>
                            </a>
                            <ul class="nav nav-sub dk">
                                <li class="nav-sub-header">
                                    <a href="">
                                        <span>Form</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="form_element.html">
                                        <span>Form elements</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <a href="ui_chart.html">
                                <i class="glyphicon glyphicon-signal"></i>
                                <span>Chart</span>
                            </a>
                        </li>
                        <li>
                            <a href="" class="auto">
                  <span class="pull-right text-muted">
                    <i class="icon-arrow-right text"></i>
                    <i class="icon-arrow-down text-active"></i>
                  </span>
                                <i class="glyphicon glyphicon-file icon"></i>
                                <span>Pages</span>
                            </a>
                            <ul class="nav nav-sub dk">
                                <li class="nav-sub-header">
                                    <a href="">
                                        <span>Pages</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="page_profile.html">
                                        <span>Profile</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="page_post.html">
                                        <span>Post</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="page_search.html">
                                        <span>Search</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="page_invoice.html">
                                        <span>Invoice</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="page_price.html">
                                        <span>Price</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="page_lockme.html">
                                        <span>Lock screen</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="page_signin.html">
                                        <span>Signin</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="page_signup.html">
                                        <span>Signup</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="page_forgotpwd.html">
                                        <span>Forgot password</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="page_404.html">
                                        <span>404</span>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="line dk hidden-folded"></li>

                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span>Your Stuff</span>
                        </li>


                        @if(Auth::user()->hasAccess('platform.systems.index'))
                            <li>
                                <a href="{{ route('platform.systems.index') }}">
                                    <i class="icon-settings" aria-hidden="true"></i>
                                    <span>{{trans('platform::menu.systems')}}</span>
                                </a>
                            </li>
                        @endif

                        <li>
                            <a href="{{ route('platform.logout') }}"
                               onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                               dusk="logout-button">
                                <i class="icon-logout" aria-hidden="true"></i>
                                <span>{{trans('platform::auth/account.sign_out')}}</span>
                            </a>

                            <form id="logout-form" class="hidden" action="{{ route('platform.logout') }}"
                                  method="POST">
                                @csrf
                            </form>
                        </li>


                    </ul>
                </nav>
                <!-- nav -->
            </div>
        </div>
    </aside>



    <!-- content  -->
    <div id="content" class="app-content" role="main">

        <!-- header  -->
        <header id="header" class="app-header navbar" role="menu">
            <!-- navbar header  -->
            <div class="navbar-header bg-black dk v-center">

                <button class="pull-left click" data-toggle="open" title="Menu" data-target="#aside">
                    <i class="icon-menu"></i>
                </button>

                <!-- brand  -->
                <a href="{{route('platform.index')}}" class="navbar-brand text-lt center">
                    <i class="{{config('platform.logo')}}"></i>
                </a>
                <!-- /brand  -->

                <button class="pull-right"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="icon-logout"></i>
                </button>

            </div>
            <!-- /navbar header  -->

            <!-- navbar collapse  -->
            <div class="app-header wrapper navbar-collapse box-shadow bg-white-only v-center">

                <div class="col-xs-12 col-md-4">
                    <h1 class="m-n font-thin h3 text-black">@yield('title')</h1>
                    <small class="text-muted text-ellipsis">@yield('description')</small>
                </div>

                <div class="col-xs-12 col-md-8">
                    @yield('navbar')
                </div>


            </div>
            <!-- / navbar collapse  -->
        </header>
        <!-- / header  -->



        <div class="app-content-body" id="app-content-body">

            @include('platform::partials.alert')

            @empty(!$errors->count())
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

@endsection