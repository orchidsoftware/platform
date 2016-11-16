@extends('dashboard::layouts.dashboard')

@section('content')

    <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3">Cтатические страницы</h1>
        <small class="text-muted">Поисковая оптимизация для статических страниц</small>
    </div>

    <div class="wrapper-md" id="static-container">

        <div class="panel panel-default">
            <div class="panel-heading font-bold">Адреса</div>

            <div class="row wrapper">
                <div class="col-sm-12">
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" v-model="query" name="query"
                                   placeholder="{{trans('dashboard::common.Find')}} ...">
          <span class="input-group-btn">
            <button class="btn btn-sm btn-default" type="submit">{{trans('dashboard::common.Find')}}</button>
          </span>
                        </div>
                    </form>
                </div>
            </div>


            <div class="panel-body row">

                <div class="table-responsive">
                    <table class="table table-striped b-t b-light">
                        <thead>
                        <tr>
                            <th>Url</th>
                            <th>{{trans('dashboard::common.Manage')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(index,url) in routes | filterBy query">
                            <td><a href="@{{ baseUrl + '/' + url}}"
                                   target="_blank">@{{url}}</a></td>
                            <td class="pull-right">


                                <div class="btn-group pull-right btn-group-sm" role="group">
                                    <button v-on:click="show(index)" class="btn btn-primary">
                                        <span class="fa fa-edit"></span></button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

            </div>


        </div>


        <!-- Modal -->
        <div class="modal fade slide-down disable-scroll" id="static-modal" tabindex="-1" role="dialog"
             aria-hidden="false">
            <div class="modal-dialog">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <div class="modal-header clearfix text-left">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true"><i class="fa fa-times"></i></span>
                            </button>
                            <h5>Домен</h5>
                            <p class="p-b-10">Системная универсальная опция для хранения различных значений</p>
                        </div>
                        <div class="modal-body">


                            <form class="form-horizontal" action="{{route('dashboard.static.index')}}" method="post">

                                <div class="form-group">
                                    <label>Заголовок</label>
                                    <input class="form-control" type="text" maxlength="255" required
                                           v-model="active.title" name="title">
                                </div>


                                <div class="line line-dashed b-b line-lg"></div>

                                <div class="form-group">
                                    <label>Теги</label>
                                    <input v-model="active.keywords" class="form-control w-md" data-role="tagsinput"
                                           type="text" maxlength="255"
                                           required name="keywords">
                                </div>


                                <div class="line line-dashed b-b line-lg"></div>

                                <div class="form-group">
                                    <label>Описание</label>

        <textarea class="form-control" rows="5" maxlength="255" required v-model="active.description"
                  name="description"></textarea>
                                </div>


                                <div class="line line-dashed b-b line-lg"></div>

                                <div class="form-group">
                                    <label>Робот</label>

                                    <select class="form-control" name="robots" v-model="active.robots">
                                        <option value="all">Разрешено индексировать текст и ссылки на странице</option>
                                        <option value="noindex">Не индексировать текст страницы</option>
                                        <option value="nofollow">Запрещено индексировать текст и переходить по ссылкам
                                            на
                                            странице
                                        </option>
                                    </select>

                                </div>
                                <div class="line line-dashed b-b line-lg"></div>

                                <div class="row">
                                    <div class="col-md-offset-8 col-sm-4 m-t-10 sm-m-t-10">
                                        <button type="button" class="btn btn-primary btn-addon btn-block m-t-5"
                                                v-on:click="update">
                                            <i class="fa fa-plus"></i>
                                            Создать
                                        </button>
                                    </div>
                                </div>


                            </form>


                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- Modal -->


    </div>








@endsection

