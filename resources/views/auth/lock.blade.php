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


<div class="modal-over" style="background: #1d2531">
  <div class="modal-center" style="width:200px;margin:-100px 0 0 -100px;">

    <p class="h4 m-t m-b">tabuna</p>
        <div class="form-group form-group-default ">
            <label>Пароль</label>
            <div class="controls">
                <input type="password"
                       class="form-control"
                       name="password"
                       placeholder="Введите ваш Пароль"
                       required="">
            </div>
        </div>
  </div>
</div>


</body>
</html>
