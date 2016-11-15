@extends('dashboard::layouts.dashboard')


@section('title','Settings Page')




@section('content')





        <div class="col-md-8 no-padder">
            <!-- main header -->
            <div class="bg-light lter b-b wrapper-md">
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <h1 class="m-n font-thin h3 text-black">Settings</h1>
                        <small class="text-muted">Welcome to angulr application</small>
                    </div>
                </div>
            </div>
            <!-- / main header -->

            <div class="wrapper-md">
                <div class="bg-white">
                    <form class="form-horizontal" action="http://mautab.com/admin/settings" method="post">


                        <div class="form-group">
                            <label class="col-lg-2 control-label">Краткое описание</label>

                            <div class="col-lg-10">
                                <input type="text" name="site_descriptions" class="form-control" value="">
                                <small class="help-block m-b-none">Объясните в нескольких словах, о чём этот сайт.
                                </small>
                            </div>
                        </div>

                        <div class="line line-dashed b-b line-lg"></div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Адрес</label>

                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="site_adress" value="">
                                <small class="help-block m-b-none">Физический или юридический адрес организации</small>
                            </div>
                        </div>


                        <div class="line line-dashed b-b line-lg"></div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Телефон</label>

                            <div class="col-lg-10">
                                <input type="text" class="form-control" name="site_phone" value="">
                            </div>
                        </div>


                        <div class="line line-dashed b-b line-lg"></div>

                        <div class="form-group">
                            <label class="col-lg-2 control-label">Адрес e-mail</label>

                            <div class="col-lg-10">
                                <input type="email" class="form-control" name="site_email" value="">
                                <small class="help-block m-b-none">Этот адрес используется в целях администрирования.
                                    Например, для уведомления о новых пользователях.
                                </small>
                            </div>
                        </div>


                        <div class="form-group text-center">
                            <div class="col-md-4 col-md-offset-8">

                                {!! csrf_field() !!}

                                <button type="submit" class="btn btn-sm btn-info">Сохранить</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- / stats -->


        </div>


        <div class="col-md-4 bg-white-only b-l bg-auto no-border-xs pos-rlt">

            <!-- aside right -->
            <div class="app-aside-right no-padder  w-auto-xs bg-white b-l w-full top-left ">
                <div class="vbox">
                    <div class="wrapper b-b b-t b-light m-b">
                        <a href="" class="pull-right text-muted text-md" ui-toggle-class="show"
                           target=".app-aside-right"><i class="icon-close"></i></a>
                        Info
                    </div>
                    <div class="row-row">
                        <div class="cell">
                            <div class="cell-inner padder">


                                <table class="table">
                                    <tr>
                                        <td>Название сайта</td>
                                        <td>{{$settings->get('name')}}</td>
                                    </tr>
                                    <tr>
                                        <td>Окружение</td>
                                        <td>{{$settings->get('env')}}</td>
                                    </tr>
                                    <tr>
                                        <td>Отладка</td>
                                        <td>{{$settings->get('debug')}}</td>
                                    </tr>
                                    <tr>
                                        <td>Адрес сайта</td>
                                        <td>{{$settings->get('url')}}</td>
                                    </tr>

                                    <tr>
                                        <td>Часовой пояс</td>
                                        <td>{{$settings->get('timezone')}}</td>
                                    </tr>


                                    <tr>
                                        <td>Язык по умолчанию</td>
                                        <td>{{$settings->get('locale')}}</td>
                                    </tr>

                                    <tr>
                                        <td>Запасной язык</td>
                                        <td>{{$settings->get('fallback_locale')}}</td>
                                    </tr>
                                    <tr>
                                        <td>Журнал событий</td>
                                        <td>{{$settings->get('log')}}</td>
                                    </tr>
                                    <tr>
                                        <td>Уровень журнала событий</td>
                                        <td>{{$settings->get('log_level')}}</td>
                                    </tr>


                                </table>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- / aside right -->

        </div>













@stop




