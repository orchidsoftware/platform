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
                                <span class="m-l d-none d-sm-block"> {{config('platform.name')}} </span>
                            </p>
                        </a>

                        <ul class="m-n padder">
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
                            {{--
                            <li class="inline b-l">
                                <div class="dropdown position-relative">
                                    <div class="input-icon w-xxl m-l-sm">
                                        <input onchange="$('.test').dropdown('toggle');$().dropdown('update')"
                                               type="text" class="form-control input-sm  no-border rounded padder"
                                               placeholder="Type anywhere to search..."
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                        >
                                        <div class="input-icon-addon">
                                            <i class="icon-magnifier"></i>
                                        </div>
                                    </div>
                                    <div class="test dropdown-menu dropdown-menu-right dropdown-menu-arrow w-xxl"
                                         x-placement="start-left">

                                        <div class="hidden-folded padder m-t-xs m-b-xs text-muted text-xs">Управление контентом</div>
                                        <a href="#" class="block wrapper-sm dropdown-item">
                                    <span class="pull-left thumb-xs avatar m-r-sm">
                                      <img src="http://flatfull.com/themes/angulr/html/img/a4.jpg" alt="...">
                                      <i class="on b-white bottom"></i>
                                    </span>
                                            <span class="clear">
                                      <span class="text-ellipsis">Chris Fox</span>
                                      <small class="text-muted clear text-ellipsis">What's up, buddy What's up, buddy What's up, buddy What's up, buddy</small>
                                    </span>
                                        </a>
                                        <a href="#" class="block wrapper-sm dropdown-item">
                                    <span class="pull-left thumb-xs avatar m-r-sm">
                                      <img src="http://flatfull.com/themes/angulr/html/img/a4.jpg" alt="...">
                                      <i class="on b-white bottom"></i>
                                    </span>
                                            <span class="clear">
                                      <span class="text-ellipsis">Chris Fox</span>
                                      <small class="text-muted clear text-ellipsis">What's up, buddy What's up, buddy What's up, buddy What's up, buddy</small>
                                    </span>
                                        </a>
                                        <a href="#" class="block wrapper-sm dropdown-item">
                                    <span class="pull-left thumb-xs avatar m-r-sm">
                                      <img src="http://flatfull.com/themes/angulr/html/img/a4.jpg" alt="...">
                                      <i class="on b-white bottom"></i>
                                    </span>
                                            <span class="clear">
                                      <span class="text-ellipsis">Chris Fox</span>
                                      <small class="text-muted clear text-ellipsis">What's up, buddy What's up, buddy What's up, buddy What's up, buddy</small>
                                    </span>
                                        </a>
                                        <a href="#" class="block wrapper-sm dropdown-item">
                                    <span class="pull-left thumb-xs avatar m-r-sm">
                                      <img src="http://flatfull.com/themes/angulr/html/img/a4.jpg" alt="...">
                                      <i class="on b-white bottom"></i>
                                    </span>
                                            <span class="clear">
                                      <span class="text-ellipsis">Chris Fox</span>
                                      <small class="text-muted clear text-ellipsis">What's up, buddy What's up, buddy What's up, buddy What's up, buddy</small>
                                    </span>
                                        </a>

                                        <div class="hidden-folded padder m-t-xs m-b-xs text-muted text-xs">Управление контентом</div>
                                        <a href="#" class="block wrapper-sm dropdown-item">
                                    <span class="pull-left thumb-xs avatar m-r-sm">
                                      <img src="http://flatfull.com/themes/angulr/html/img/a4.jpg" alt="...">
                                      <i class="on b-white bottom"></i>
                                    </span>
                                            <span class="clear">
                                      <span class="text-ellipsis">Chris Fox</span>
                                      <small class="text-muted clear text-ellipsis">What's up, buddy What's up, buddy What's up, buddy What's up, buddy</small>
                                    </span>
                                        </a>
                                        <a href="#" class="block wrapper-sm dropdown-item">
                                    <span class="pull-left thumb-xs avatar m-r-sm">
                                      <img src="http://flatfull.com/themes/angulr/html/img/a4.jpg" alt="...">
                                      <i class="on b-white bottom"></i>
                                    </span>
                                            <span class="clear">
                                      <span class="text-ellipsis">Chris Fox</span>
                                      <small class="text-muted clear text-ellipsis">What's up, buddy What's up, buddy What's up, buddy What's up, buddy</small>
                                    </span>
                                        </a>
                                        <a href="#" class="block wrapper-sm dropdown-item">
                                    <span class="pull-left thumb-xs avatar m-r-sm">
                                      <img src="http://flatfull.com/themes/angulr/html/img/a4.jpg" alt="...">
                                      <i class="on b-white bottom"></i>
                                    </span>
                                            <span class="clear">
                                      <span class="text-ellipsis">Chris Fox</span>
                                      <small class="text-muted clear text-ellipsis">What's up, buddy What's up, buddy What's up, buddy What's up, buddy</small>
                                    </span>
                                        </a>
                                        <a href="#" class="block wrapper-sm dropdown-item">
                                    <span class="pull-left thumb-xs avatar m-r-sm">
                                      <img src="http://flatfull.com/themes/angulr/html/img/a4.jpg" alt="...">
                                      <i class="on b-white bottom"></i>
                                    </span>
                                            <span class="clear">
                                      <span class="text-ellipsis">Chris Fox</span>
                                      <small class="text-muted clear text-ellipsis">What's up, buddy What's up, buddy What's up, buddy What's up, buddy</small>
                                    </span>
                                        </a>
                                    </div>
                                </div>
                            </li>
                            --}}
                        </ul>


                        <div class="d-flex order-lg-2 ml-auto">

                            @include('platform::partials.search')

                            @include('platform::partials.notifications')

                            <div class="dropdown">
                                <a href="#" class="nav-link p-0 v-center" data-toggle="dropdown">
                                    <span class="thumb-xs avatar">
                                        <img src="{{Auth::user()->getAvatar()}}" class="b bg-light" alt="test">
                                    </span>
                                    <span class="ml-2 d-none d-lg-block" style="max-width:150px;font-size: 0.82857rem;">
                                        <span class="text-ellipsis">{{Auth::user()->getNameTitle()}}</span>
                                        <span class="text-muted d-block text-ellipsis">{{Auth::user()->getSubTitle()}}</span>
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
                        <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse"
                           data-target="#headerMenuCollapse">
                            <span class="header-toggler-icon icon-menu"></span>
                        </a>
                    </div>
                </div>
            </div>

            <nav class="header collapse d-lg-flex p-0 bg-white b-b box-shadow-lg navbar" id="headerMenuCollapse">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg order-lg-first">
                            <ul class="nav nav-tabs  border-0 flex-column flex-lg-row">
                                {!! Dashboard::menu()->render('Main') !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

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
                   Designed and built with all the love in the world.
                   Currently v{{\Orchid\Platform\Dashboard::VERSION}}.
                </span>
                </p>
            </div>
            <div class="col-md-6 text-right">
                <p class="small m-n">© 2016 - {{date('Y')}} The application code is published under the MIT license.</p>
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