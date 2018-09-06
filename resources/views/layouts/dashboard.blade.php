@extends('platform::layouts.app')


@section('body')

    <div class="app" id="app" data-controller="@yield('controller')">
        <div class="app-header">
            <div class="header py-4 bg-white b-b">
                <div class="container">
                    <div class="d-flex v-center">
                        <a class="header-brand" href="{{route('platform.index')}}">
                            <img src="{{url('/orchid/img/orchid.svg')}}" class="header-brand-img" alt="logo" height="32px"
                                 width="150px">
                        </a>
                        <div class="d-flex order-lg-2 ml-auto">
                            <div class="dropdown d-none d-md-flex">
                                <a class="nav-link icon" data-toggle="dropdown">
                                    <i class="icon-bell"></i>
                                    <span class="badge badge-sm up bg-danger pull-right-xs">2</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    @include('platform::partials.notifications')
                                </div>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="nav-link p-0 v-center" data-toggle="dropdown">
                                    <span class="thumb-xs avatar pull-right m-t-n-sm m-b-n-sm m-r-xs">
                                        <img src="/orchid/img/avatars/users-1.svg" class="b bg-light" alt="test">
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
                        <div class="col-lg-3 ml-auto">
                            <form class="input-icon my-3 my-lg-0">
                                <input type="search" class="form-control header-search" placeholder="Search…" tabindex="1">
                                <div class="input-icon-addon">
                                    <i class="icon-magnifier"></i>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg order-lg-first">
                            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                                {!! Dashboard::menu()->render('Main') !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container m-b-lg">

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

    <div class="footer bg-white b-b b-t small">
        <div class="container">
            <div class="row padder-v">
                <div class="col-lg-8">
                    <div class="row">
                        <div class="col-6 col-md-3">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#">First link</a></li>
                                <li><a href="#">Second link</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-3">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#">Third link</a></li>
                                <li><a href="#">Fourth link</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-3">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#">Fifth link</a></li>
                                <li><a href="#">Sixth link</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-3">
                            <ul class="list-unstyled mb-0">
                                <li><a href="#">Other link</a></li>
                                <li><a href="#">Last link</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <span class="text-muted">Premium and Open Source dashboard template with responsive and high quality UI. For Free!</span>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer bg-white">
        <div class="container">
            <div class="row align-items-center flex-row-reverse padder-v">
                <div class="col-auto ml-lg-auto">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <ul class="list-inline list-inline-dots mb-0">
                                <li class="list-inline-item"><a href="../docs/index.html">Documentation</a></li>
                                <li class="list-inline-item"><a href="../faq.html">FAQ</a></li>
                            </ul>
                        </div>
                        <div class="col-auto">
                            <a href="" class="btn btn-outline-primary btn-sm">Source code</a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center small">
                    © 2016 - {{date('Y')}} The application code is published under the MIT license.
                </div>
            </div>
        </div>
    </footer>


    @include('platform::partials.support')
@endsection