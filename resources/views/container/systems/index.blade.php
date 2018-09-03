@extends('platform::layouts.dashboard')

@section('title',trans('platform::systems/settings.title'))
@section('description', trans('platform::systems/settings.description'))
@section('controller','layouts--systems')

@section('navbar')
    <div class="pull-right">
        <div class="input-group  w-xxl">
            <input
                    data-action="keyup->layouts--systems#filter"
                    type="text" class="form-control input-sm bg-light no-border rounded padder"
                    placeholder="{{trans('platform::systems/settings.search')}}">
        </div>
    </div>
@stop

@section('content')
    <div class="bg-white">

        <div class="admin-wrapper wrapper-md">
            <div class="row">

                <div class="col-md-2">
                    @foreach($settings as $key => $value)
                        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                            <span>{{trans('platform::systems/settings.app.'.$key)}}</span>
                        </li>

                        <li class="padder text-ellipsis">
                            <span class="m-l"> - {{$settings->get($key) }}</span>
                        </li>
                    @endforeach
                </div>

                @php
                    $menu = Dashboard::menu()->build('Systems');
                    $chunk = ceil($menu->count() / 2);
                    $menu =  $menu->chunk($chunk);
                @endphp

                @foreach($menu as $items)
                    <div class="col-md-5 admin-element-item">

                        @foreach($items as $item)
                            @include('platform::partials.systems.systemsMenu', [
                                'icon' => $item['icon'],
                                'label' => $item['label'],
                                'children' => $item['children'],
                            ])
                        @endforeach

                    </div>
                @endforeach


            </div>
        </div>

    </div>

@stop