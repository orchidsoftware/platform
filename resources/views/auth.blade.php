@extends('platform::app')

@section('body')

    <div class="container-md">
        <div class="form-signin h-full min-vh-100 d-flex flex-column justify-content-center">

            <a class="d-flex justify-content-center mb-4 p-0 px-sm-5" href="{{Dashboard::prefix()}}">
                @includeFirst([config('platform.template.header'), 'platform::header'])
            </a>

            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-6 col-xxl-5 px-md-5">

                    <div class="bg-white p-4 p-sm-5 rounded shadow-sm">
                        @yield('content')
                    </div>
                </div>
            </div>


            @includeFirst([config('platform.template.footer'), 'platform::footer'])
        </div>
    </div>

@endsection
