<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title','ORCHID')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="apple-touch-icon" sizes="180x180" href="/orchid/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/orchid/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/orchid/favicon/favicon-16x16.png">
    <link rel="manifest" href="/orchid/favicon/manifest.json">
    <link rel="mask-icon" href="/orchid/favicon/safari-pinned-tab.svg" color="#1a2021">
    <meta name="apple-mobile-web-app-title" content="ORCHID">
    <meta name="application-name" content="ORCHID">
    <meta name="theme-color" content="#ffffff">

    <meta name="dashboard-prefix" content="{{Dashboard::prefix()}}">
    <meta name="description"
          content="Laravel Platform application provides a very flexible and extensible way of building your custom application.">
    <meta property="og:title" content="@yield('title','ORCHID')"/>
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:image" content="{{config('content.image','/orchid/img/background.jpg')}}"/>

    <link rel="stylesheet" href="{{mix('/css/orchid.css','orchid')}}" type="text/css"/>
    <script async="async" src="{{mix('/js/orchid.js','orchid')}}" type="text/javascript"></script>
</head>
<body>


<div class="login-wrapper">

    <div class="bg-pic">

        <img src="{{config('platform.auth.image','/orchid/img/background.jpg')}}" alt="" class="lazy">


        <div class="bg-caption pull-bottom text-white wrapper-md m-b-md">
            <h2 class="text-white">
                {{config('platform.auth.slogan',trans('dashboard::auth/account.slogan'))}}
            </h2>
            <p class="small">
                {{trans('dashboard::auth/account.image-license')}}<br>
                © 2013 - {{date('Y')}} ORCHID.
            </p>
        </div>

    </div>


    <div class="login-container bg-white b-l b-l-light">
        <div class="padder-lg m-t-lg">

            <a href="/{{Dashboard::prefix()}}">
                <img src="/orchid/img/orchid.svg" alt="logo" data-src="assets/img/logo.png"
                     data-src-retina="assets/img/logo_2x.png" height="22">
            </a>


            @yield('content')

            <div class="pull-bottom">
                <div class="m-b-lg clearfix v-center">
                    <div class="col-sm-3 col-md-2">
                        <a href="https://orchid.software/"><img alt="ORCHID"
                                                                class="m-t-xs"
                                                                src="/orchid/img/logo.svg"
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


</body>
</html>
