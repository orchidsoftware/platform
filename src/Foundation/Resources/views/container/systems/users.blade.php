@extends('dashboard::layouts.dashboard')

@section('content')



    <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3">Пользователи</h1>
        <small class="text-muted">Системные активные аккаунты</small>
    </div>

    <div class="wrapper-md" id="users-container">


        <div class="panel ">
            <div class="panel-heading">
                <div class="panel-title v-center m-t-md">

                    <div class="col-md-6 font-bold">
                        Участники системы
                    </div>
                    <div class="col-md-6">

                        <div class="pull-right">
                            <div class="btn-group">
                                <a class="btn btn-default"><i class="fa fa-plus"></i></a>
                                <a class="btn btn-default"><i class="fa fa-file-excel-o"></i></a>
                                <a class="btn btn-default"><i class="fa fa-file-pdf-o"></i></a>
                                <a class="btn btn-default"><i class="fa fa-copy"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table table-striped" role="grid">
                        <thead>
                        <tr>
                            <th>{{trans('dashboard::common.Manage')}}</th>
                            <th>@sortablelink ('name','name')</th>
                            <th>@sortablelink ('email','email')</th>
                            <th>@sortablelink ('created_at',trans('dashboard::common.Created'))</th>
                            <th>@sortablelink ('updated_at',trans('dashboard::common.Last edit'))</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tbody>
                        @foreach ($Users as $user)
                            <tr>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-link dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-bars"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a href="{{ route('dashboard.users.edit',$user->id) }}"
                                                   class="">
                                                    Редактировать <i class="fa fa-edit"></i> </a>

                                            </li>
                                            <li>
                                                <a href="#" data-toggle="modal" data-target="#Modal-{{$user->id}}"
                                                   class="">
                                                    Удалить <i class="fa fa-trash"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>

                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at }}</td>
                                <td>{{ $user->updated_at }}</td>
                            </tr>

                        @endforeach
                        </tbody>
                        </tbody>
                    </table>
                </div>

                <div class="row">
                    <div class="v-center m-l-md m-r-md">

                        <div class="text-muted inline m-t-sm m-b-sm small col-md-6" role="status">
                            {{trans('dashboard::common.show')}} {{$Users->total()}}
                            -{{$Users->perPage()}} {{trans('dashboard::common.of')}} {!! $Users->count() !!} {{trans('dashboard::common.elements')}}
                        </div>


                        <div class="col-md-6 text-right pagination-table">
                            {!! $Users->render() !!}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>







    <!-- Modal -->
    <div class="modal fade slide-down disable-scroll" id="settings-modal" tabindex="-1" role="dialog"
         aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content-wrapper">
                <div class="modal-content">
                    <div class="modal-header clearfix text-left">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="fa fa-times"></i></span>
                        </button>
                        <h5>Константа</h5>
                        <p class="p-b-10">Системная универсальная опция для хранения различных значений</p>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" action="#" method="post">

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Название</label>
                                <div class="col-lg-10">
                                    <input type="text" name="key" class="form-control">
                                </div>
                            </div>

                            <div class="line line-dashed b-b line-lg"></div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Значение</label>

                                <div class="col-lg-10">
                                    <input type="text" name="value" class="form-control">
                                </div>
                            </div>


                            <div class="line line-dashed b-b line-lg"></div>

                            <div class="row">
                                <div class="col-md-offset-8 col-sm-4 m-t-10 sm-m-t-10">
                                    <button type="button" class="btn btn-primary btn-addon btn-block m-t-5">
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

@endsection
