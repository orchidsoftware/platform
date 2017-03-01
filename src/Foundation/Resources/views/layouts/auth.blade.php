<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title','Orchid')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('/orchid/css/orchid.css')}}" type="text/css"/>
    <script async="async" src="{{asset('/orchid/js/orchid.js')}}" type="text/javascript"></script>
</head>
<body>



<div class="login-wrapper">

    <div class="bg-pic">

        <img src="{{config('content.image','/orchid/img/background.jpg')}}" alt="" class="lazy">


        <div class="bg-caption pull-bottom text-white wrapper-md m-b-md">
            <h2 class="text-white">
                Позволяет легко наслаждаться тем, что действительно имеет значение в жизни
            </h2>
            <p class="small">
                Изображения, размещаемые исключительно только для целей представления, все работы авторского права соответствующего владельца, в противном случае © 2013-2016 Orchid.
            </p>
        </div>

    </div>


    <div class="login-container bg-white b-l b-l-light">
        <div class="padder-lg m-t-lg">

            <a href="{{url('/dashboard')}}">
                <img src="/orchid/img/orchid.svg" alt="logo" data-src="assets/img/logo.png" data-src-retina="assets/img/logo_2x.png" height="22">
            </a>



            @yield('content')

            <div class="pull-bottom">
                <div class="m-b-lg clearfix v-center">
                    <div class="col-sm-3 col-md-2">
                        <img alt="" class="m-t-xs"  src="/orchid/img/logo.svg"  width="78" height="22">
                    </div>
                    <div class="col-sm-9 no-padding m-t-10">
                        <p>
                            <small>

                                Создать аккаунт страницы. Если у вас есть учетная запись facebook, войти в него для этого процесса. Войти через <a href="#" class="text-info">Facebook</a> или <a href="#" class="text-info">Google</a>
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
