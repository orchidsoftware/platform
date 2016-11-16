<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('container','Orchid')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('/orchid/css/orchid.css')}}" type="text/css"/>
</head>

<body class="install bg-dark bg-gd-dk">

@yield('container')


<script src="{{asset('/orchid/js/orchid.js')}}" type="text/javascript"></script>
</body>
</html>
