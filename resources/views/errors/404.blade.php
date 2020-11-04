@extends('platform::dashboard')

@section('title', '404')
@section('description', __("You requested a page that doesn't exist."))

@section('content')

    <div class="container p-md-5 layout">
        <div class="display-1 text-muted mb-5 mt-sm-5 mt-0">
            <x-orchid-icon path="bug"/>
            404
        </div>
        <h1 class="h2 mb-3">{{ __("You requested a page that doesn't exist.") }}</h1>
        <p class="h4 text-muted font-weight-normal mb-7">{{ __("You may have' entered an address that doesn't exist or that the link you have requested doesn't work (anymore).") }}</p>
    </div>

@endsection
