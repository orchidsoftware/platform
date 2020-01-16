@extends('platform::app')

@section('body-left')
    <div class="hidden-xs v-center h-100 w-100 justify-content-center">
        <div class="text-center">
            <a href="{{Dashboard::prefix()}}">
                @includeFirst([config('platform.template.header'), 'platform::header'])
            </a>
        </div>
    </div>

@endsection


@section('body-right')

    <div class="v-center h-100 w-100 justify-content-center">
        <div class="container">
            <div class="row">
                <div class="col mx-auto p-5" style="max-width: 30rem;">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

@endsection
