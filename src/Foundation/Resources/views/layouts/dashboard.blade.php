<!DOCTYPE html>
<html lang="{{App::getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>@yield('title') - Orchid</title>
    <meta name="csrf_token" content="{{csrf_token()}}">
    <meta name="auth" content="{{Auth::check()}}">
    <link rel="stylesheet" href="/orchid/css/orchid.css">

    @stack('stylesheet')

</head>


<body>
<div id="app" class="app app-header-fixed app-aside-fixed">

    <!-- header -->
    <header id="header" class="app-header navbar" role="menu">
        <!-- navbar header -->
        <div class="navbar-header bg-black">
            <button class="pull-right visible-xs dk">
                <i class="fa fa-cog"></i>
            </button>
            <button class="pull-right visible-xs">
                <i class="fa fa-bars"></i>
            </button>
            <!-- brand -->
            <a href="{{route('dashboard.index')}}" class="navbar-brand text-lt">
                <img src="/orchid/img/logo.svg" width="50px">
                <!--<span class="hidden-folded m-l-xs">Orchid</span>-->
            </a>
            <!-- / brand -->
        </div>
        <!-- / navbar header -->

        <!-- navbar collapse -->
        @include('dashboard::partials.navbar')
                <!-- / navbar collapse -->
    </header>
    <!-- / header -->




    <!-- aside -->
    <aside id="aside" class="app-aside hidden-xs">
        <div class="aside-wrap-main  b-b b-dark">


            <div class="navi-wrap">

                <!-- nav -->
                <nav class="navi clearfix">
                    <ul class="nav" role="tablist">


                        <li>
                            <a href="http://localhost:8000/dashboard" class="navbar-brand text-lt w-full">
                                <img src="/orchid/img/logo.svg" width="50px">
                            </a>
                        </li>


                        {!! Dashboard::menu()->render('Main') !!}


                        <li>
                            <a href="#">
                                <i class="fa fa-send text-info-lter"></i>
                                <span>Email</span>
                            </a>
                        </li>


                    </ul>

                    <ul class="nav-footer-fix">
                        <li><a href="#"><i class="icon-grid" aria-hidden="true"></i></a></li>
                        <li><a href="#"><i class="icon-settings" aria-hidden="true"></i></a></li>
                    </ul>

                </nav>
                <!-- nav -->
            </div>



        </div>

        <div class="aside-wrap">
            <div class="navi-wrap">

                <!-- nav -->
                <nav class="navi clearfix h-full">
                    <ul class="nav h-full b-b b-dark tab-content">
                        {!! Dashboard::menu()->render('Main','dashboard::partials.leftSubMenu') !!}
                    </ul>
                </nav>
                <!-- nav -->

                <!-- aside footer -->
                <div class="wrapper m-t">

                    <div class="text-center-folded">
                        <span class="pull-right pull-none-folded">60%</span>
                        <span class="hidden-folded">Закрытых заказов</span>
                    </div>
                    <div class="progress progress-xxs m-t-sm lter">
                        <div class="progress-bar progress-bar-info" style="width: 60%;">
                        </div>
                    </div>
                    <div class="text-center-folded">
                        <span class="pull-right pull-none-folded">35%</span>
                        <span class="hidden-folded">Заказов в процессе</span>
                    </div>
                    <div class="progress progress-xxs m-t-sm lter">
                        <div class="progress-bar progress-bar-primary" style="width: 35%;">
                        </div>
                    </div>
                </div>
                <!-- / aside footer -->
            </div>
        </div>




    </aside>
    <!-- / aside -->




    <!-- content -->
    <div id="content" class="app-content" role="main">
        <div class="app-content-body" id="app-content-body">

            @include('dashboard::partials.alert')


            @if (count($errors) > 0)
                <div class="alert alert-danger m-b-none" role="alert"><strong>Oh snap!</strong> Change a few things up and try
                    submitting again.
                    <ul class="m-t-xs">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                    </ul>
                </div>
            @endif



            @yield('content')
        </div>
    </div>
    <!-- /content -->

    <!-- footer -->
    <footer id="footer" class="app-footer" role="footer">
        <div class="wrapper b-t bg-light">
            <span class="pull-right">{{ App::VERSION() }}
                <a href="" class="m-l-sm text-muted"> <i class="fa fa-github"></i></a>
                <a href="" class="m-l-sm text-muted"> <i class="fa fa-long-arrow-up"></i></a>
            </span>
            © {{date("Y")}} Copyright.
        </div>
    </footer>
    <!-- / footer -->


</div>






@include('dashboard::partials.quick')


<script src="/orchid/js/orchid.js" type="text/javascript"></script>

@stack('scripts')

</body>
</html>
