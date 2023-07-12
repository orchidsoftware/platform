@extends('platform::dashboard')

@section('title', '404')
@section('description', __("You requested a page that doesn't exist."))

@section('content')

    <div class="container py-md-4">
            <h1 class="h2 mb-3">
                {{ __("Sorry, we don't have anything to show you on this page") }}
            </h1>


            <p>{{ __("This could be because:") }}</p>
            <ul>
                <li>{{ __("The item you're looking for has been deleted") }}</li>
                <li>{{ __("You don't have access to it") }}</li>
                <li>{{ __("You clicked a broken link") }}</li>
            </ul>

            <p class="mb-0">{{ __("If you think you should have access to this page, ask the person who manages the project (or the account) to add you to it.") }}</p>
    </div>

@endsection
