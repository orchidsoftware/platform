@extends('platform::app')


@section('body-right')

    <div class="v-center mt-5 w-100 justify-content-center">
        <div class="container mt-5">
            <div class="row">
                <div class="col mx-auto bg-white p-5 rounded shadow-sm" style="max-width: 32rem;">

                    <div class="text-center mb-4">
                        <a href="{{Dashboard::prefix()}}">
                            @includeFirst([config('platform.template.header'), 'platform::header'])
                        </a>
                    </div>

                    @yield('content')
                </div>
            </div>

            <div class="row">
                <div class="col mt-5 text-center">
                    @includeFirst([config('platform.template.footer'), 'platform::footer'])
                </div>
            </div>
        </div>
    </div>

@endsection
