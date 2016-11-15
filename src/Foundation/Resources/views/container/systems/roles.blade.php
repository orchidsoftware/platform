@extends('dashboard::layouts.dashboard')

@section('content')



    <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3">Роли</h1>
        <small class="text-muted">Разграничение прав доступа</small>
    </div>

    <div class="wrapper-md" id="users-container">

        <div class="panel panel-default">
            <div class="panel-heading font-bold">Роли</div>


            <div class="row wrapper">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="delete">{{trans('dashboard::common.Delete')}}</option>
                    </select>
                    <button class="btn btn-sm btn-default">{{trans('dashboard::common.Apply')}}</button>
                </div>
                <div class="col-sm-4">
                    <button class="btn m-b-xs btn-sm btn-default btn-addon" data-toggle="modal"
                            data-target="#settings-modal"><i
                                class="fa fa-plus"></i>{{trans('dashboard::common.Create')}}</button>
                </div>
                <div class="col-sm-3">
                    <form action="">
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="search"
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
                            <th>@sortablelink ('id','#')</th>
                            <th>@sortablelink ('name','name')</th>
                            <th>@sortablelink ('email','slug')</th>
                            <th>@sortablelink ('created_at',trans('dashboard::common.Created'))</th>
                            <th>@sortablelink ('updated_at',trans('dashboard::common.Last edit'))</th>
                            <th>{{trans('dashboard::common.Manage')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($Roles as $role)
                            <tr>
                                <td>
                                    <label class="i-checks m-b-none">
                                        <input type="checkbox"
                                               name="settings[{{ $role->id }}]"><i></i>
                                    </label>
                                </td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->slug }}</td>
                                <td>{{ $role->created_at }}</td>
                                <td>{{ $role->updated_at }}</td>
                                <td>
                                    <div class="btn-group pull-right btn-group-sm" role="group" aria-label="...">
                                        <a href="{{ route('dashboard.roles.edit',$role->slug) }}"
                                           class="btn btn-default"><span class="fa fa-edit"></span> </a>
                                        <a href="#" data-toggle="modal" data-target="#Modal-{{$role->slug}}"
                                           class="btn btn-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @endforeach
                        </tbody>
                    </table>
                </div>

            </div>

            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-4 hidden-xs">
                        <select class="input-sm form-control w-sm inline v-middle">
                            <option value="delete">{{trans('dashboard::common.Delete')}}</option>
                        </select>
                        <button class="btn btn-sm btn-default">{{trans('dashboard::common.Apply')}}</button>
                    </div>
                    <div class="col-sm-4 text-center">
                        <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$Roles->total()}}
                            -{{$Roles->perPage()}} {{trans('dashboard::common.of')}} {!! $Roles->count() !!} {{trans('dashboard::common.elements')}}</small>
                    </div>
                    <div class="col-sm-4 text-right text-center-xs">
                        {!! $Roles->render() !!}
                    </div>
                </div>
            </footer>

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
