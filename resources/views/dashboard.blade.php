@extends('platform::app')

@section('body-left')

    <div class="aside col-xs-12 col-md-2 col-xl-2 col-xxl-3 bg-dark">
        <div class="d-md-flex align-items-start flex-column d-sm-block h-full">

            <div class="d-sm-flex d-md-block p-3 mt-md-4 w-100 v-center">
                <a href="#" class="header-toggler d-md-none mr-auto order-first d-flex align-items-center"
                   data-toggle="collapse"
                   data-target="#headerMenuCollapse">
                    <x-orchid-icon path="menu" class="icon-menu"/>

                    <span class="ml-2">@yield('title')</span>
                </a>

                <a class="header-brand order-last" href="{{route('platform.index')}}">
                    @includeFirst([config('platform.template.header'), 'platform::header'])
                </a>
            </div>

            <nav class="collapse d-md-block w-100 mb-md-3" id="headerMenuCollapse">

                @include('platform::partials.search')

                @includeWhen(Auth::check(), 'platform::partials.profile')

                <ul class="nav flex-column mb-1">
                    {!! Dashboard::menu()->render('Main') !!}
                </ul>

            </nav>

            <div class="h-100 w-100 position-relative to-top cursor d-none d-md-block mt-md-5 divider"
                 data-action="click->layouts--html-load#goToTop"
                 title="{{ __('Scroll to top') }}">
                <div class="bottom-left w-100 mb-2 pl-3">
                    <small>
                        <x-orchid-icon path="arrow-up" class="mr-2"/>

                        {{ __('Scroll to top') }}
                    </small>
                </div>
            </div>

            <div class="p-3 mb-2 m-t d-none d-lg-block w-100">
                @includeFirst([config('platform.template.footer'), 'platform::footer'])
            </div>

        </div>
    </div>
@endsection

@section('body-right')

    <div class="mt-3 mt-md-4">

        @if(Breadcrumbs::has())
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb px-4 m-0">
                    <x-tabuna-breadcrumbs
                        class="breadcrumb-item"
                        active="active"
                    />
                </ol>
            </nav>
        @endif

        <div class="@hasSection('navbar') @else d-none d-md-block @endif layout v-md-center">
            <div class="d-none d-md-block col-xs-12 col-md p-0">
                <h1 class="m-0 font-weight-light h3 text-black">@yield('title')</h1>
                <small class="text-muted" title="@yield('description')">@yield('description')</small>
            </div>
            <div class="col-xs-12 col-md-auto ml-auto p-0">
                <ul class="nav command-bar justify-content-sm-end justify-content-start v-center">
                    @yield('navbar')
                </ul>
            </div>
        </div>

        @include('platform::partials.alert')
        @yield('content')
    </div>
@endsection
