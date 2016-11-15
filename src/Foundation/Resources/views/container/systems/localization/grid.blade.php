@extends('dashboard::layouts.dashboard')


@section('title','Localization Page')


@section('content')
<header class="bg-light lter b-b wrapper-md">
    <div class="row">
        <div class="col-sm-6 col-xs-12">
            <h1 class="m-n font-thin h3 text-black">Localization</h1>
            <small class="text-muted">Добавление языков и настройка параметров локали</small>
        </div>
    </div>
</header>
<section class="bg-white-only b-l bg-auto no-border-xs">
        <div class="panel-body row">
            <div class="pull-right m-r-md">
                <button class="btn btn-success"><i class="fa fa-plus"></i></button>
                <button class="btn btn-danger"><i class="fa fa-trash"></i></button>
            </div>
            @if($localizations->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>{{trans('dashboard::common.Manage')}}</th>
                            <th>Имя</th>
                            <th>Ссылка</th>
                            <th>{{trans('dashboard::common.Last edit')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
</section>
@stop