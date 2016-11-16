@extends('dashboard::layouts.dashboard')


@section('title','Localization Page')


@section('content')
<header class="bg-light lter b-b wrapper-md">
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1 class="m-n font-thin h3 text-black">Localization</h1>
            <small class="text-muted">Добавление языков и настройка параметров локали</small>
        </div>
        <div class="pull-right m-r-md">
            <a href="{{route('dashboard.systems.localization.create')}}" class="btn btn-success"><i class="fa fa-plus"></i></a>
            <a class="btn btn-danger"><i class="fa fa-trash"></i></a>
        </div>
    </div>
</header>
<section class="bg-white-only b-l bg-auto no-border-xs">
        <div class="panel-body row">
            @if($localizations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Название</th>
                                <th>Код</th>
                                <th>Статус</th>
                                <th>{{trans('dashboard::common.Manage')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($localizations as $localization)
                            <tr>
                                <td>{{$localization['name']}}</td>
                                <td>{{$localization['code']}}</td>
                                <td> @if ($localization['status']) Включен @else Выключен @endif </td>
                                <td>
                                    <a href="{{route('dashboard.systems.localization.edit', $localization['id'])}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                    <a href="{{route('dashboard.systems.localization.edit', $localization['id'])}}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
</section>
@stop