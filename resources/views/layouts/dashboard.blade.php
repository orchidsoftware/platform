@extends('platform::layouts.app')


@section('body')

    <div class="app" id="app" data-controller="@yield('controller')">
        <div class="app-header">

            @include('platform::partials.announcement')

            <div class="header py-4 bg-white b-b">
                <div class="container">
                    <div class="d-flex v-center">
                        <a class="header-brand" href="{{route('platform.index')}}">
                            <p class="h2 n-m font-thin v-center">
                                <i class="icon-orchid text-primary"></i>
                                <span class="m-l d-none d-sm-block"> {{config('app.name')}} </span>
                            </p>
                        </a>

                        <ul class="m-n">
                            @if(Dashboard::menu()->showCountElement('Quick'))
                                <li class="inline">
                                    <div class="dropdown">
                                        <a href="#" class="nav-link" data-toggle="dropdown"><i class="icon-options"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                            {!! Dashboard::menu()->render('Quick','platform::partials.dropdownMenu') !!}
                                        </div>
                                    </div>
                                </li>
                            @endif
                            <li class="inline b-l">
                                <a href="#" class="nav-link" data-toggle="modal" data-target="#globalSearch">
                                    <i class="icon-magnifier m-r-xs"></i>Type anywhere to <span
                                            class="font-bold">search</span>
                                </a>
                            </li>
                        </ul>


                        <div class="d-flex order-lg-2 ml-auto">


                            @include('platform::partials.notifications')

                            <div class="dropdown">
                                <a href="#" class="nav-link p-0 v-center" data-toggle="dropdown">
                                    <span class="thumb-xs avatar">
                                        <img src="{{Auth::user()->getAvatar()}}" class="b bg-light" alt="test">
                                    </span>
                                    <span class="ml-2 d-none d-lg-block" style="max-width:150px;font-size: 0.82857rem;">
                                        <span class="text-ellipsis">{{Auth::user()->getNameTitle()}}</span>
                                        <span class="text-muted d-block mt-1 text-ellipsis">{{Auth::user()->getSubTitle()}}</span>
                                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
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
                                        <form id="return-original-user" class="hidden" action="{{ route('platform.systems.users.edit',[Auth::user(),'switchUserStop']) }}"
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

        </div>


        <div class="container">

            <div class="v-center m-t-md m-b-md">
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

            <div class="d-flex">
                <div class="app-content-body" id="app-content-body">
                    @include('platform::partials.alert')
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <footer class="container footer">
        <div class="row d-none">
            <div class="col-md-12 text-center padder-v">
                <button class="btn btn-link">
                    <i class="icon icon-arrow-up-circle m-r-xs"></i>
                    <span>Наверх</span>
                </button>
            </div>
        </div>

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

            <input id="overlay-search" class="no-border overlay-search bg-transparent" placeholder="Search..."
                   autocomplete="off" spellcheck="false">
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