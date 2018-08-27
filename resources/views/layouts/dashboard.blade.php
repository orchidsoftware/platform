@extends('platform::layouts.app')


@section('body')

<div id="app" class="app" data-controller="@yield('controller')">

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

    <!-- aside  -->
    <aside id="aside" class="app-aside d-none d-md-block" data-controller="layouts--left-menu">
        <div class="aside-wrap-main">

            <div class="navi-wrap">

                <!-- nav  -->
                <nav class="navi clearfix">
                    <ul class="nav flex-column" role="tablist">

                        {{--
                        <li class="nav-item">
                            <a href="#" class="nav-link click" data-toggle="open" title="Menu" data-target="#aside">
                                <i class="icon-menu" aria-hidden="true"></i>
                            </a>
                        </li>
                        --}}

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


    <!-- content  -->
    <div id="content" class="app-content" role="main">
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