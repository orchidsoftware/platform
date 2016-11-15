<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title','Orchid')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{asset('/orchid/css/orchid.css')}}" type="text/css"/>
</head>

<body class="install bg-dark bg-gd-dk">

<div class="install-body container">
    <div class="col-md-8 col-md-offset-2">


        <div class="center w-xs wrapper-md">
            <img src="/orchid/img/logo.svg" class="img-responsive">
        </div>

        <div class="bg-white b-l b-r b-dark b-l-r">


            <div class="hbox hbox-auto-xs hbox-auto-sm">
                <div class="col w-md b-r">
                    <div class="wrapper hidden-sm hidden-xs">
                        <ul class="nav nav-pills nav-stacked nav-sm">
                            <li><a href="#">Welcome To The <Installer></Installer></a></li>
                            <li><a href="#">Requirements</a></li>
                            <li><a href="#">Permissions</a></li>
                            <li><a href="#">Environment Settings</a></li>
                            <li><a href="#">Create Administrator</a></li>
                            <li><a href="#">Install</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col">

                    <div class="wrapper">
                        @yield('container')

                    </div>
                </div>
            </div>


        </div>


    </div>
</div>


<script src="{{asset('/orchid/js/orchid.js')}}" type="text/javascript"></script>
</body>
</html>