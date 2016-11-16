@extends('dashboard::layouts.dashboard')

@section('content')

    <div class="bg-light lter b-b wrapper-md">
        <h1 class="m-n font-thin h3">Локализация</h1>
        <small class="text-muted">Языки поддерживаемые системой</small>
    </div>

    <div class="wrapper-md" id="language-container">

        <div class="panel panel-default">
            <div class="panel-heading font-bold">Языки</div>


            <div class="row wrapper">
                <div class="col-sm-5 m-b-xs">
                    <select class="input-sm form-control w-sm inline v-middle">
                        <option value="delete">{{trans('dashboard::common.Delete')}}</option>
                    </select>
                    <button class="btn btn-sm btn-default">{{trans('dashboard::common.Apply')}}</button>
                </div>
                <div class="col-sm-4">
                    <button class="btn m-b-xs btn-sm btn-default btn-addon" data-toggle="modal"
                            data-target="#language-modal"><i
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
                            <th>@sortablelink ('name','Имя')</th>
                            <th>@sortablelink ('code','Код')</th>
                            <th>@sortablelink ('status','Статус')</th>
                            <th>@sortablelink ('created_at',trans('dashboard::common.Created'))</th>
                            <th>@sortablelink ('updated_at',trans('dashboard::common.Last edit'))</th>
                            <th>{{trans('dashboard::common.Manage')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($Languages as $lang)
                            <tr>
                                <td>
                                    <label class="i-checks m-b-none">
                                        <input type="checkbox"
                                               name="language[{{ $lang->id }}]"><i></i>
                                    </label>
                                </td>
                                <td>{{ $lang->name }}</td>
                                <td>{{ $lang->code }}</td>
                                <td>@if($lang->status)
                                        <i class="fa fa-check text-success"></i>
                                    @else
                                        <i class="fa fa-times text-danger"></i>
                                    @endif</td>
                                <td>{{ $lang->created_at }}</td>
                                <td>{{ $lang->updated_at }}</td>
                                <td>

                                    <div class="btn-group pull-right btn-group-sm" role="group" aria-label="...">
                                        <a href="{{ route('dashboard.language.edit',$lang->id) }}"
                                           class="btn btn-default"><span class="fa fa-edit"></span> </a>
                                        <a href="#" data-toggle="modal" data-target="#Modal-{{$lang->id}}"
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
                        <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$Languages->total()}}
                            -{{$Languages->perPage()}} {{trans('dashboard::common.of')}} {!! $Languages->count() !!} {{trans('dashboard::common.elements')}}</small>
                    </div>
                    <div class="col-sm-4 text-right text-center-xs">
                        {!! $Languages->render() !!}
                    </div>
                </div>
            </footer>

        </div>


    </div>







    <!-- Modal -->
    <div class="modal fade slide-down disable-scroll" id="language-modal" tabindex="-1" role="dialog"
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


                        <form class="form-horizontal" action="{{route('dashboard.language.store')}}" method="post">

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Название</label>

                                <div class="col-lg-10">
                                    <input type="text" name="name" class="form-control">
                                </div>
                            </div>

                            <div class="line line-dashed b-b line-lg"></div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Код</label>

                                <div class="col-lg-10">
                                    <input type="text" name="code" class="form-control">
                                </div>
                            </div>

                            <div class="line line-dashed b-b line-lg"></div>

                            <div class="form-group">
                                <label class="col-lg-2 control-label">Статус</label>

                                <div class="col-lg-4">
                                    <label class="i-switch bg-success m-t-xs m-r">
                                        <input type="radio" name="status" value="1" checked>
                                        <i></i>
                                    </label>
                                    <label class="i-switch bg-danger m-t-xs m-r">
                                        <input type="radio" name="status" value="0">
                                        <i></i>
                                    </label>
                                </div>

                                <div class="col-lg-6">
                                    {!! csrf_field() !!}
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

