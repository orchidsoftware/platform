@extends('platform::layouts.dashboard')

@section('title','Systems')
@section('description', 'Global for Systems')

@section('content')

<div class="bg-white">

    <div class="admin-wrapper container wrapper-md">
        <div class="row">

             @foreach(Dashboard::menu()->build('Systems')->chunk(2) as $items)
                 <div class="col-md-5 col-md-4">

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