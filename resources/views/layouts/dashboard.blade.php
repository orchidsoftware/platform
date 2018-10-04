@extends('platform::layouts.app')


@section('body')


    <div class="app row m-n" id="app" data-controller="@yield('controller')">


        <div class="aside col-xs-12 col-md-2 offset-md-2 no-padder bg-dark">

            <div class="d-flex v-center wrapper mt-md-4">

                <a class="header-brand" href="{{route('platform.index')}}">
                    <p class="h2 n-m font-thin v-center">
                        <i class="icon-orchid text-primary"></i>
                        <span class="m-l d-none d-sm-block">
Orchid
<small style="
vertical-align: top;
opacity: .75;
">Platform</small>
</span>
                    </p>
                </a>

                <a href="#" class="header-toggler d-lg-none ml-auto" data-toggle="collapse"
                   data-target="#headerMenuCollapse">
                    <span class="header-toggler-icon icon-menu"></span>
                </a>

            </div>


            <nav class="collapse d-lg-block" id="headerMenuCollapse">

                @include('platform::partials.search')


                <div class="wrapper v-center">
                    <div class="dropdown">
                        <a href="#" class="nav-link p-0 v-center" data-toggle="dropdown">
                    <span class="thumb-xs avatar m-r-xs">
                        <img src="{{Auth::user()->getAvatar()}}" class="b bg-light" alt="test">
                    </span>
                            <span class="ml-2 d-none d-lg-block" style="width:140px;font-size: 0.82857rem;">
                        <span class="text-ellipsis">{{Auth::user()->getNameTitle()}}</span>
                        <span class="text-muted d-block text-ellipsis">{{Auth::user()->getSubTitle()}}</span>
                    </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow bg-white">
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
                    @include('platform::partials.notifications')
                </div>


                <ul class="nav flex-column m-b">
                    {!! Dashboard::menu()->render('Main') !!}
                </ul>

            </nav>

            <div class="wrapper m-b m-t d-none d-lg-block">
                <div class="text-center">
                    <p class="small m-n">
                        © 2016 - {{date('Y')}} The application code is published under the MIT license.<br>
                        Currently v{{\Orchid\Platform\Dashboard::VERSION}}.
                    </p>
                </div>
            </div>

        </div>
        <div class="col-md-6 bg-white b-r box-shadow-lg no-padder">

            <div class="wrapper mt-4">
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
                    @include('platform::partials.announcement')
                    @yield('content')
                </div>
            </div>

        </div>
    </div>

@endsection