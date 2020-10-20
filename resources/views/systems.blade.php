@extends('platform::dashboard')

@section('title',__('System settings'))
@section('description', __('Back-end preferences'))
@section('controller','layouts--systems')

@section('navbar')
    <div class="float-sm-right">
        <div class="input-icon w-auto">
            <input
                    data-action="keyup->layouts--systems#filter"
                    type="text" class="form-control input-sm bg-light no-border rounded padder"
                    placeholder="{{__('Search...')}}">
            <div class="input-icon-addon">
                <x-orchid-icon path="magnifier"/>
            </div>
        </div>
    </div>
@stop

@section('content')

    <div class="admin-wrapper bg-white rounded shadow-sm p-4">
        <div class="row">

                @php
                    /** @var \Illuminate\Support\Collection $menu */
                    $menu = Dashboard::menu()->build('Systems');
                    $chunk = ceil($menu->count() / 2);
                    $menu = $menu->chunk($chunk);
                @endphp

                @foreach($menu as $items)
                    <div class="col-md-6 admin-element-item">

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

@stop
