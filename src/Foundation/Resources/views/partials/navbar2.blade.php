<div class="collapse pos-rlt navbar-collapse box-shadow bg-white-only">
    <!-- buttons -->
    <div class="nav navbar-nav hidden-xs">
        <a href="{{Config('app.url')}}" class="btn no-shadow navbar-btn">
            <i class="fa fa-globe"></i>
        </a>


    </div>
    <!-- / buttons -->

    <!-- link and dropdown -->
    <ul class="nav navbar-nav hidden-sm">


        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                <i class="fa fa-bars fa-fw"></i>
                <span class="visible-xs-inline">Notifications</span>
                <span class="badge badge-sm up bg-danger pull-right-xs">{{
                $UserNotification->where('read',false)->count() ? $UserNotification->where('read',false)->count() : ""
                }}</span>
            </a>
            <!-- dropdown -->
            <div class="dropdown-menu w-xl animated fadeInUp">
                <div class="panel bg-white">
                    <div class="panel-heading b-light bg-light">
                        <strong>You have <span>2</span> notifications</strong>
                    </div>
                    <div class="list-group">
                        <a href="" class="list-group-item">
                    <span class="clear block m-b-none">
                      1.0 initial released<br>
                      <small class="text-muted">1 hour ago</small>
                    </span>
                        </a>
                    </div>
                    <div class="panel-footer text-sm">
                        <a href="" class="pull-right"><i class="fa fa-cog"></i></a>
                        <a href="#notes" data-toggle="class:show animated fadeInRight">See all the
                            notifications</a>
                    </div>
                </div>
            </div>
            <!-- / dropdown -->
        </li>
        <li class="dropdown pos-stc">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                <span>Mega</span>
                <span class="caret"></span>
            </a>

            <div class="dropdown-menu wrapper w-full bg-white">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="m-l-xs m-t-xs m-b-xs font-bold">Pages <span
                                    class="badge badge-sm bg-success">10</span></div>
                        <div class="row">
                            <div class="col-xs-6">
                                <ul class="list-unstyled l-h-2x">
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Profile</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Post</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Search</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Invoice</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-6">
                                <ul class="list-unstyled l-h-2x">
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Price</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Lock
                                            screen</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Sign
                                            in</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Sign
                                            up</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 b-l b-light">
                        <div class="m-l-xs m-t-xs m-b-xs font-bold">UI Kits <span
                                    class="label label-sm bg-primary">12</span></div>
                        <div class="row">
                            <div class="col-xs-6">
                                <ul class="list-unstyled l-h-2x">
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Buttons</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Icons
                                            <span class="badge badge-sm bg-warning">1000+</span></a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Grid</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Widgets</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-xs-6">
                                <ul class="list-unstyled l-h-2x">
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Bootstap</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Sortable</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Portlet</a>
                                    </li>
                                    <li>
                                        <a href=""><i class="fa fa-fw fa-angle-right text-muted m-r-xs"></i>Timeline</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 b-l b-light">
                        <div class="m-l-xs m-t-xs m-b-sm font-bold">Analysis</div>
                        <div class="text-center">
                            <div class="inline">
                                <div ui-jq="easyPieChart" ui-options="{
                          percent: 65,
                          lineWidth: 50,
                          trackColor: '#e8eff0',
                          barColor: '#23b7e5',
                          scaleColor: false,
                          size: 100,
                          rotate: 90,
                          lineCap: 'butt',
                          animate: 2000
                        }" class="easyPieChart" style="width: 100px; height: 100px; line-height: 100px;">
                                    <canvas width="100" height="100"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                <i class="fa fa-fw fa-plus visible-xs-inline-block"></i>
                <span> Создать</span> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#" translate="header.navbar.new.PROJECT">Projects</a></li>
                <li>
                    <a href="">
                        <span class="badge bg-info pull-right">5</span>
                        <span translate="header.navbar.new.TASK">Task</span>
                    </a>
                </li>
                <li><a href="" translate="header.navbar.new.USER">User</a></li>
                <li class="divider"></li>
                <li>
                    <a href="">
                        <span class="badge bg-danger pull-right">4</span>
                        <span translate="header.navbar.new.EMAIL">Email</span>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    <!-- / link and dropdown -->

    <!-- search form -->
    <form class="navbar-form navbar-form-sm navbar-left shift"
          data-target=".navbar-collapse" role="search">
        <div class="form-group">
            <div class="input-group">
                <input type="text"
                       class="form-control input-sm bg-light no-border rounded padder"
                       placeholder="Поиск...">
              <span class="input-group-btn">
                <button type="submit" class="btn btn-sm bg-light rounded"><i class="fa fa-search"></i></button>
              </span>
            </div>
        </div>
    </form>
    <!-- / search form -->

    <!-- nabar right -->
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" data-toggle="dropdown" class="dropdown-toggle clear">
                <span class="">{{Auth::user()->name}}</span> <b class="caret"></b>
            </a>
            <!-- dropdown -->
            <ul class="dropdown-menu animated fadeInRight w-full">
                <li class="wrapper b-b m-b-sm bg-light m-t-n-xs">
                    <div>
                        <p>300mb из 500mb</p>
                    </div>
                    <div class="progress progress-xs m-b-none dker">
                        <div class="progress-bar progress-bar-info" data-toggle="tooltip"
                             data-original-title="50%" style="width: 50%"></div>
                    </div>
                </li>
                <li>
                    <a href="">
                        <span class="badge bg-danger pull-right">30%</span>
                        <span>Настройки</span>
                    </a>
                </li>
                <li>
                    <a ui-sref="app.page.profile">Профиль</a>
                </li>
                <li>
                    <a ui-sref="app.docs">
                        <span class="label bg-info pull-right">новое</span>
                        Помощь
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="{{ url('/dashboard/logout') }}"
                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                        Logout
                    </a>

                    <form id="logout-form" action="{{ url('/dashboard/logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </li>
            </ul>
            <!-- / dropdown -->
        </li>

        <li>
            <a href="#" class="click" data-toggle="open" data-target="#quickview">
                <i class="fa fa-bars fa-fw"></i>
                <span class="visible-xs-inline">Notifications</span>
                <span class="badge badge-sm up bg-danger pull-right-xs">{{
                $UserNotification->where('read',false)->count() ? $UserNotification->where('read',false)->count() : ""
                }}</span>
            </a>
        </li>


    </ul>
    <!-- / navbar right -->
</div>
