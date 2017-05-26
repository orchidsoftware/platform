<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title','Orchid')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="apple-touch-icon" sizes="180x180" href="/orchid/apple-touch-icon.png">
    <link rel="icon" type="image/png" href="/orchid/favicon-32x32.png" sizes="32x32">
    <link rel="icon" type="image/png" href="/orchid/favicon-16x16.png" sizes="16x16">
    <link rel="manifest" href="/orchid/manifest.json">
    <link rel="mask-icon" href="/orchid/safari-pinned-tab.svg" color="#ac5ca0">
    <meta name="theme-color" content="#f8f9fa">


    <meta name="description"
          content="Laravel Platform application provides a very flexible and extensible way of building your custom application.">
    <meta property="og:title" content="@yield('title','Orchid')"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:image" content="{{config('content.image','/orchid/img/background.jpg')}}"/>

    <link rel="stylesheet" href="{{asset('/orchid/css/orchid.css')}}" type="text/css"/>
    <script async="async" src="{{asset('/orchid/js/orchid.js')}}" type="text/javascript"></script>
</head>
<body>


<div class="login-wrapper">

    <div class="bg-pic">

        <img src="{{config('content.auth.image','/orchid/img/background.jpg')}}" alt="" class="lazy">


        <div class="bg-caption pull-bottom text-white wrapper-md m-b-md">
            <h2 class="text-white">
                {{trans('dashboard::auth/account.slogan')}}
            </h2>
            <p class="small">
                {{trans('dashboard::auth/account.image-license')}}<br>
                © 2013-{{date('Y')}} Orchid.
            </p>
        </div>

    </div>


    <div class="login-container bg-white b-l b-l-light">
        <div class="padder-lg m-t-lg">

            <a href="{{url('/dashboard')}}">
                <img src="/orchid/img/orchid.svg" alt="logo" data-src="assets/img/logo.png"
                     data-src-retina="assets/img/logo_2x.png" height="22">
            </a>


            @yield('content')

            <div class="pull-bottom">
                <div class="m-b-lg clearfix v-center">
                    <div class="col-sm-3 col-md-2">
                        <img alt="" class="m-t-xs" src="/orchid/img/logo.svg" width="78" height="22">
                    </div>
                    <div class="col-sm-9 no-padding">
                        <p class="m-l-md">
                            <small>

                                License & Source Code<br>
                                Orchid is freely available under the MIT. <br>
                                The source is available on <a href="https://github.com/TheOrchid/Platform"
                                                              class="text-info" target="_blank"
                                                              rel="noopener noreferrer">github</a>.

                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


</body>
</html>
