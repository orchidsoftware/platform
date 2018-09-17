@extends('platform::layouts.app')


@section('body')

    <div class="app" id="app" data-controller="@yield('controller')">
        <div class="app-header">

            @include('platform::partials.announcement')

            <div class="header py-4 bg-white b-b">
                <div class="container">
                    <div class="d-flex v-center">
                        <a class="header-brand" href="{{route('platform.index')}}">
                            <img src="{{url('/orchid/img/orchid.svg')}}" class="header-brand-img" alt="logo" height="32px"
                                 width="150px">
                        </a>


                        <ul class="m-n b-r">
                            <li class="inline">
                                <a href="#" class="nav-link"><i class="icon-options"></i></a>
                            </li>
                            <li class="inline dropdown dropdown-toggle">
                                <a href="#" class="nav-link text-uppercase" data-toggle="dropdown" role="button"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-globe m-r-xs"></i> <span id="code-local">en</span>

                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" data-target="#local-en" role="tab" data-toggle="tab"
                                       onclick="document.getElementById('code-local').innerHTML = 'en'"
                                       aria-controls="local-en" aria-expanded="true ">English
                                    </a>
                                    <a class="dropdown-item" data-target="#local-ru" role="tab" data-toggle="tab"
                                       onclick="document.getElementById('code-local').innerHTML = 'ru'"
                                       aria-controls="local-ru" aria-expanded=" false ">Россия
                                    </a>
                                </div>
                            </li>
                        </ul>

                        <a href="#" class="nav-link" data-toggle="modal" data-target="#globalSearch">
                            <i class="icon-magnifier m-r-xs"></i>Type anywhere to <span class="font-bold">search</span>
                        </a>

                        <div class="d-flex order-lg-2 ml-auto">


                            @include('platform::partials.notifications')

                            <div class="dropdown">
                                <a href="#" class="nav-link p-0 v-center" data-toggle="dropdown">
                                    <span class="thumb-xs avatar pull-right m-t-n-sm m-b-n-sm m-r-xs">
                                        <img src="{{Auth::user()->getAvatar()}}" class="b bg-light" alt="test">
                                    </span>
                                    <span class="ml-2 d-none d-lg-block" style="max-width:150px;font-size: 0.82857rem;">
                                        <span class="text-ellipsis">{{Auth::user()->getNameTitle()}}</span>
                                        <span class="text-muted d-block mt-1 text-ellipsis">{{Auth::user()->getSubTitle()}}</span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="#">
                                        <i class="m-r-xs icon-user"></i> Profile
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="m-r-xs icon-settings"></i> Settings
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <span class="float-right"><span class="badge bg-info">6</span></span>
                                        <i class="m-r-xs icon-paper-plane"></i> Inbox
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="m-r-xs icon-server"></i> Message
                                    </a>
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
                                </div>
                            </div>
                        </div>
                        <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse"
                           data-target="#headerMenuCollapse">
                            <span class="header-toggler-icon icon-menu"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="header collapse d-lg-flex p-0 bg-white b-b box-shadow-lg" id="headerMenuCollapse">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg order-lg-first">
                            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                                {!! Dashboard::menu()->render('Main') !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">

                <div class="v-center m-t-md m-b-md">
                    <div class="col-xs-12 col-md-4">
                        <h1 class="m-n font-thin h3 text-black">@yield('title')</h1>
                        <small class="text-muted text-ellipsis">@yield('description')</small>
                    </div>
                    <div class="col-xs-12 col-md-8">
                        @yield('navbar')
                    </div>
                </div>

                @if (Breadcrumbs::exists())
                    {{ Breadcrumbs::view('platform::partials.breadcrumbs') }}
                @endif

                <div class="d-flex">
                    <div class="app-content-body" id="app-content-body">

                        @include('platform::partials.alert')

                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="container footer">
        <div class="row padder-v m-b m-t">
            <div class="col-md-6 text-left">
                <p class="small m-n">
                <span class="sm-block">
                    Premium and Open Source dashboard.
                    <a href="#" class="m-l-10 m-r-10">Terms of use</a>
                    <span class="muted">|</span>
                    <a href="#" class="m-l-10">Privacy Policy</a>
                </span>
                </p>
            </div>
            <div class="col-md-6 text-right">
                <p class="small m-n">© 2016 - 2018 The application code is published under the MIT license.</p>
            </div>
        </div>
    </footer>


    <div class="modal fade fill-in" id="globalSearch" tabindex="-1" role="dialog" aria-hidden="true">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="icon-close"></i>
        </button>

        <div class="container-fluid">

            <img class="overlay-brand" src="{{url('/orchid/img/orchid.svg')}}" height="32px"
                 width="150px" alt="logo">


            <a href="#" class="close-icon-light overlay-close text-black fs-16">
                <i class="icon-close"></i>
            </a>

        </div>

        <div class="container-fluid">

            <input id="overlay-search" class="no-border overlay-search bg-transparent" placeholder="Search..." autocomplete="off" spellcheck="false">
            <br>
            <div class="inline-block">
                <div class="checkbox right">
                    <input id="checkboxn" type="checkbox" value="1" checked="checked">
                    <label for="checkboxn"><i class="fa fa-search"></i> Search within page</label>
                </div>
            </div>
            <div class="inline-block m-l-10">
                <p class="fs-13">Press enter to search</p>
            </div>

        </div>

    </div>

    @include('platform::partials.support')
@endsection