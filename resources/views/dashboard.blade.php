@extends('platform::app')

@section('body-left')

    <div class="d-sm-flex d-md-block wrapper mt-md-4 w-full v-center">
        <a href="#" class="header-toggler d-md-none mr-auto order-first"
           data-toggle="collapse"
           data-target="#headerMenuCollapse">
            <span class="header-toggler-icon icon-menu"></span>
            <span class="ml-2">@yield('title')</span>
        </a>

        <a class="header-brand order-last" href="{{route('platform.index')}}">
            @includeIf(config('platform.template.header','platform::header'))
        </a>
    </div>

    <nav class="collapse d-md-block w-full" id="headerMenuCollapse">

        @include('platform::partials.search')

        @includeWhen(Auth::check(), 'platform::partials.profile')

        <ul class="nav flex-column m-b">
            {!! Dashboard::menu()->render('Main') !!}
        </ul>

    </nav>

    <div class="h-100 w-100 position-relative to-top cursor b-b mt-md-5"
         data-action="click->layouts--html-load#goToTop"
         title="{{ __('Go to top') }}"
         style="border-bottom: 1px solid rgba(233, 236, 239, 0.05);">
        <div class="bottom-left w-100 mb-2 pl-3">
            <small><i class="icon-arrow-up mr-2"></i> {{ __('Go to top') }}</small>
        </div>
    </div>

    <div class="wrapper m-b m-t d-none d-lg-block w-full">
        @includeIf(config('platform.template.footer','platform::footer'))
    </div>
@endsection

@section('body-right')
    <div class="wrapper mt-md-4 @hasSection('navbar') @else d-none d-md-block @endif">
        <div class="v-md-center">
            <div class="d-none d-md-block col-xs-12 col-md-4 no-padder">
                <h1 class="m-n font-thin h3 text-black">@yield('title')</h1>
                <small class="text-muted text-ellipsis" title="@yield('description')">@yield('description')</small>
            </div>
            <div class="col-xs-12 col-md-8 no-padder">
                <ul class="nav command-bar justify-content-sm-end justify-content-start v-center">
                    @yield('navbar')
                </ul>
            </div>
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
@endsection
