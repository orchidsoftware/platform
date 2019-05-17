@extends('platform::dashboard')

@section('content')

    <div class="container text-center">
        <div class="display-1 text-muted mb-5 mt-5"><i class="icon-bug"></i> 404</div>
        <h1 class="h2 mb-3">{{ __("You request a page that doesn't exist.") }}</h1>
        <p class="h4 text-muted font-weight-normal mb-7">{{ __("It's possible you entered the wrong address or the link doesn't work.") }}</p>
        <a class="btn btn-link m-t-md" href="javascript:history.back()">
            <i class="fe fe-arrow-left mr-2"></i>{{ __('Go back') }}
        </a>
    </div>

@endsection