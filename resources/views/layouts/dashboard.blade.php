@extends('platform::layouts.app')

@section('body')

    <div class="app row m-n" id="app" data-controller="@yield('controller')" @yield('controller-data')>

        <div class="aside col-xs-12 col-md-3 col-xl-2 col-xxl-2 offset-xl-1 offset-xxl-2 no-padder bg-dark">


            <div class="d-md-flex align-items-start flex-column d-sm-block h-full">

            <div class="d-sm-flex d-md-block wrapper mt-md-4 w-full">

                <a class="header-brand" href="{{route('platform.index')}}">
                    @includeIf(config('platform.template.header','platform::layouts.header'))
                </a>

                <a href="#" class="header-toggler d-lg-none ml-auto" data-toggle="collapse"
                   data-target="#headerMenuCollapse">
                    <span class="header-toggler-icon icon-menu"></span>
                </a>
            </div>

            <nav class="collapse d-lg-block w-full" id="headerMenuCollapse">

                @include('platform::partials.search')

                @includeWhen(Auth::check(), 'platform::partials.profile')

                <ul class="nav flex-column m-b">
                    {!! Dashboard::menu()->render('Main') !!}
                </ul>

            </nav>

            <div class="h-100 w-100 position-relative to-top cursor"
                 data-action="click->layouts--html-load#goToTop"
                 title="Go to top"
                 style="border-bottom: 1px solid #5c6269;">
                <div class="bottom-left w-100 mb-2">
                    <small><i class="icon-arrow-up m-r-xs"></i> Go to top</small>
                </div>
            </div>

            <div class="wrapper m-b m-t d-none d-lg-block">
                @includeIf(config('platform.template.footer','platform::layouts.footer'))
            </div>

            </div>

        </div>
        <div class="col-md-9 col-xl-8 col-xxl-6 bg-white b-r box-shadow-lg no-padder">

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
            </div>

            @if (Breadcrumbs::exists())
                {{ Breadcrumbs::view('platform::partials.breadcrumbs') }}
            @endif

            <div class="d-flex">
                <div class="app-content-body" id="app-content-body">
                    @include('platform::partials.announcement')
                    @include('platform::partials.alert')
                    @yield('content')
                </div>
            </div>

        </div>
    </div>

@endsection