@extends('platform::layouts.app')


@section('body')


    <div class="page">
        <div class="page-main">
            <div class="header py-4 bg-white b-b">
                <div class="container">
                    <div class="d-flex">
                        <a class="header-brand" href="{{route('platform.index')}}">
                            <img src="/orchid/img/orchid.svg" class="header-brand-img" alt="logo" height="32px" width="150px">
                        </a>
                        <div class="d-flex order-lg-2 ml-auto">
                            <div class="dropdown d-none d-md-flex">
                                <a class="nav-link icon" data-toggle="dropdown">
                                    <i class="icon-bell"></i>
                                    <span class="nav-unread"></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a href="#" class="dropdown-item d-flex">
                                        <span class="avatar mr-3 align-self-center" style="background-image: url(https://tabler.github.io/tabler/demo/faces/male/41.jpg)"></span>
                                        <div>
                                            <strong>Nathan</strong> pushed new commit: Fix page load performance issue.
                                            <div class="small text-muted">10 minutes ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item d-flex">
                                        <span class="avatar mr-3 align-self-center" style="background-image: url(https://tabler.github.io/tabler/demo/faces/female/1.jpg)"></span>
                                        <div>
                                            <strong>Alice</strong> started new task: Tabler UI design.
                                            <div class="small text-muted">1 hour ago</div>
                                        </div>
                                    </a>
                                    <a href="#" class="dropdown-item d-flex">
                                        <span class="avatar mr-3 align-self-center" style="background-image: url(https://tabler.github.io/tabler/demo/faces/female/18.jpg)"></span>
                                        <div>
                                            <strong>Rose</strong> deployed new version of NodeJS REST Api V3
                                            <div class="small text-muted">2 hours ago</div>
                                        </div>
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item text-center text-muted-dark">Mark all as read</a>
                                </div>
                            </div>
                            <div class="dropdown">
                                <a href="#" class="nav-link p-0 leading-none" data-toggle="dropdown">
                                    <span class="avatar" style="background-image: url(https://tabler.github.io/tabler/demo/faces/female/25.jpg)"></span>
                                    <span class="ml-2 d-none d-lg-block" style="font-size: 0.82857rem;">
                      <span class="text-default">Jane Pearson</span>
                      <span class="text-muted d-block mt-1">Administrator</span>
                    </span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon icon-user"></i> Profile
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon icon-settings"></i> Settings
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <span class="float-right"><span class="badge badge-primary">6</span></span>
                                        <i class="dropdown-icon fe fe-mail"></i> Inbox
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon icon-server"></i> Message
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon fe fe-help-circle"></i> Need help?
                                    </a>
                                    <a class="dropdown-item" href="#">
                                        <i class="dropdown-icon icon-circle"></i> Sign out
                                    </a>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                            <span class="header-toggler-icon icon-menu"></span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="header collapse d-lg-flex p-0 bg-white b-b box-shadow-lg" id="headerMenuCollapse">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3 ml-auto">
                            <form class="input-icon my-3 my-lg-0">
                                <input type="search" class="form-control header-search" placeholder="Search…" tabindex="1">
                                <div class="input-icon-addon">
                                    <i class="fe fe-search"></i>
                                </div>
                            </form>
                        </div>
                        <div class="col-lg order-lg-first">
                            <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                                <li class="nav-item">
                                    <a href="../index.html" class="nav-link padder-v"><i class="icon-home"></i> Home</a>
                                </li>
                                <li class="nav-item">
                                    <a href="javascript:void(0)" class="nav-link  padder-v" data-toggle="dropdown"><i class="icon-android"></i> Interface</a>
                                    <div class="dropdown-menu dropdown-menu-arrow">
                                        <a href="../cards.html" class="dropdown-item ">Cards design</a>
                                        <a href="../charts.html" class="dropdown-item ">Charts</a>
                                        <a href="../pricing-cards.html" class="dropdown-item ">Pricing cards</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="javascript:void(0)" class="nav-link padder-v" data-toggle="dropdown"><i class="icon-bag"></i> Components</a>
                                    <div class="dropdown-menu dropdown-menu-arrow">
                                        <a href="../maps.html" class="dropdown-item">Maps</a>
                                        <a href="../icons.html" class="dropdown-item">Icons</a>
                                        <a href="../store.html" class="dropdown-item">Store</a>
                                        <a href="../blog.html" class="dropdown-item">Blog</a>
                                        <a href="../carousel.html" class="dropdown-item ">Carousel</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="javascript:void(0)" class="nav-link padder-v" data-toggle="dropdown"><i class="icon-brush"></i> Pages</a>
                                    <div class="dropdown-menu dropdown-menu-arrow">
                                        <a href="../profile.html" class="dropdown-item ">Profile</a>
                                        <a href="../login.html" class="dropdown-item ">Login</a>
                                        <a href="../register.html" class="dropdown-item ">Register</a>
                                        <a href="../forgot-password.html" class="dropdown-item ">Forgot password</a>
                                        <a href="../400.html" class="dropdown-item ">400 error</a>
                                        <a href="../401.html" class="dropdown-item ">401 error</a>
                                        <a href="../403.html" class="dropdown-item ">403 error</a>
                                        <a href="../404.html" class="dropdown-item ">404 error</a>
                                        <a href="../500.html" class="dropdown-item ">500 error</a>
                                        <a href="../503.html" class="dropdown-item ">503 error</a>
                                        <a href="../email.html" class="dropdown-item ">Email</a>
                                        <a href="../empty.html" class="dropdown-item ">Empty page</a>
                                        <a href="../rtl.html" class="dropdown-item ">RTL mode</a>
                                    </div>
                                </li>
                                <li class="nav-item dropdown">
                                    <a href="../form-elements.html" class="nav-link padder-v"><i class="icon-bubble"></i> Forms</a>
                                </li>
                                <li class="nav-item">
                                    <a href="../gallery.html" class="nav-link padder-v"><i class="icon-camera"></i> Gallery</a>
                                </li>
                                <li class="nav-item">
                                    <a href="../docs/index.html" class="nav-link active padder-v" style="
      border-left: none;
    border-right: none;
    border-top: none;
    border-color: #40ae4a;
    background: inherit;"><i class="icon-chemistry"></i> Documentation</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-3 my-md-5">


                <div class="container">
                    <div class="row">
                        <div class="b bg-white box-shadow">
                            @yield('content')
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="footer bg-white b-b b-t small">
            <div class="container">
                <div class="row padder-v">
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-6 col-md-3">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#">First link</a></li>
                                    <li><a href="#">Second link</a></li>
                                </ul>
                            </div>
                            <div class="col-6 col-md-3">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#">Third link</a></li>
                                    <li><a href="#">Fourth link</a></li>
                                </ul>
                            </div>
                            <div class="col-6 col-md-3">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#">Fifth link</a></li>
                                    <li><a href="#">Sixth link</a></li>
                                </ul>
                            </div>
                            <div class="col-6 col-md-3">
                                <ul class="list-unstyled mb-0">
                                    <li><a href="#">Other link</a></li>
                                    <li><a href="#">Last link</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mt-4 mt-lg-0">
                        <span class="text-muted">Premium and Open Source dashboard template with responsive and high quality UI. For Free!</span>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer bg-white">
            <div class="container">
                <div class="row align-items-center flex-row-reverse padder-v">
                    <div class="col-auto ml-lg-auto">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <ul class="list-inline list-inline-dots mb-0">
                                    <li class="list-inline-item"><a href="../docs/index.html">Documentation</a></li>
                                    <li class="list-inline-item"><a href="../faq.html">FAQ</a></li>
                                </ul>
                            </div>
                            <div class="col-auto">
                                <a href="" class="btn btn-outline-primary btn-sm">Source code</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center small">
                        Copyright © 2018 All rights reserved.
                    </div>
                </div>
            </div>
        </footer>
    </div>

@endsection