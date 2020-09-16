@extends('platform::dashboard')

@section('title', '404')
@section('description', __("You request a page that doesn't exist."))

@section('content')

    <div class="container p-md-5 layout">
        <div class="display-1 text-muted mb-5 mt-sm-5 mt-0">
            <x-orchid-icon path="bug"/>
            404
        </div>
        <h1 class="h2 mb-3">{{ __("You request a page that doesn't exist.") }}</h1>
        <p class="h4 text-muted font-weight-normal mb-7">{{ __("It's possible you entered the wrong address or the link doesn't work.") }}</p>
    </div>

@endsection
