@extends('platform::layouts.app')


@section('body')

<div class="" style="
    display: -ms-flexbox;
    display: flex;
    -ms-flex-direction: column;
    flex-direction: column;
    -ms-flex-pack: center;
    justify-content: center;
    min-height: 100%;
">
    <div class="page-single">
        <div class="container">
            <div class="row">
                <div class="col col-login mx-auto" style="
    max-width: 30rem;
">

                    <div class="card">
                        <div class="card-body p-5">

                            <div class="card-title">
                                <div class="text-center mb-4">
                                    <a href="{{Dashboard::prefix()}}">
                                        <p class="h2 n-m font-thin v-center">
                                            <i class="icon-orchid text-primary"></i>
                                            <span class="m-l d-none d-sm-block"> {{config('app.name')}} </span>
                                        </p>
                                    </a>
                                </div>
                            </div>

                            @yield('content')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection