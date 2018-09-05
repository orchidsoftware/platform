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
                <img src="/orchid/img/orchid.svg" alt="logo" data-src="assets/img/logo.png"
                     data-src-retina="assets/img/logo_2x.png" height="22">
            </a>


            @yield('content')

            <div class="pull-bottom">
                <div class="m-b-lg clearfix v-center">
                    <div class="col-sm-3 col-md-2">
                        <a href="https://orchid.software/" target="_blank" rel="noopener noreferrer">
                            <img alt="ORCHID"
                                                                class="m-t-xs"
                                                                src="{{url('/orchid/img/logo.svg')}}"
                                                                width="78"
                                                                height="22"></a>
                    </div>
                    <div class="col-sm-9 no-padding">
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