@extends('platform::layouts.app')


@section('body')

<div class="login-wrapper">

    <div class="bg-pic">

        <img src="{{config('platform.auth.image','/orchid/img/background.jpg')}}" alt="ORCHID">

        <div class="bg-caption pull-bottom text-white wrapper-md m-b-md">
            <h2 class="text-white">
                {{trans(config('platform.auth.slogan','platform::auth/account.slogan'))}}
            </h2>
            <p class="small">
                {{trans('platform::auth/account.image-license')}}<br>
                © 2016 - {{date('Y')}} ORCHID.
            </p>
        </div>

    </div>


    <div class="login-container bg-white b-l b-l-light">
        <div class="padder-lg m-t-lg">

            <a href="{{Dashboard::prefix()}}">
                <p class="h2 n-m font-thin v-center">
                    <i class="icon-orchid text-primary"></i>
                    <span class="m-l d-none d-sm-block"> {{config('app.name')}} </span>
                </p>
            </a>


            @yield('content')

            <div class="pull-bottom">
                <div class="m-b-lg clearfix v-center">
                    <div class="col-sm-3 col-md-2 text-center">
                        <a href="https://orchid.software/" target="_blank" class="h1 m-t-xs" title="ORCHID" rel="noopener noreferrer">
                            <i class="icon-orchid text-primary m-t-xs"></i>
                        </a>
                    </div>
                    <div class="col-sm-9 no-padder">
                        <p class="m-l-md">
                            <small>

                                License & Source Code<br>
                                ORCHID is freely available under the MIT. <br>
                                The source is available on <a href="https://github.com/orchidsoftware/platform"
                                                              class="text-info" target="_blank"
                                                              rel="noopener noreferrer">GitHub</a>.

                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection