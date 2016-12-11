@extends('dashboard::layouts.dashboard')


@section('title',$name)
@section('description',$description)



@section('navbar')
    <div class="col-sm-6 col-xs-12 text-right">
        <div class="btn-group" role="group" aria-label="...">
            <button type="submit" form="form-group" class="btn btn-link"><i class="ion-ios-compose-outline fa fa-2x"></i></button>
            <button type="submit" form="form-group-remove" class="btn btn-link"  @if($method == 'create') disabled @endif><i class="ion-ios-trash-outline  fa fa-2x"></i></button>
        </div>
    </div>
@stop


@section('content')


    <!-- main content -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs">
        <div class="nav-tabs-alt">
            <ul class="nav nav-tabs" role="tablist">


                @foreach($forms as $name => $form)
                    <li @if ($loop->first) class="active" @endif>
                        <a data-target="#tab-{{str_slug($name)}}" role="tab" data-toggle="tab">
                            {{$name}}
                        </a>
                    </li>
                @endforeach

            </ul>
        </div>


        <form class="form-horizontal" id="form-group"

              @if($method == 'create')
              action="{{route($route->get('store')['name'])}}"
              @elseif($method == 'update')
              action="{{route($route->get('update')['name'],$model->$slug)}}"
              @endif
              method="post" enctype="multipart/form-data">




            <div class="tab-content">
                @foreach($forms as $name => $form)
                    <div role="tabpanel" class="tab-pane @if ($loop->first) active @endif" id="tab-{{str_slug($name)}}">
                        {!! $form !!}
                    </div>
                @endforeach
            </div>


            {{csrf_field()}}


            @if($route->get($method)['method'] != 'GET')
               {{ method_field( $route->get($method)['method'] )}}
            @endif

        </form>



        @if($method != 'create')
            <form id="form-group-remove" action="{{route($route->get('destroy')['name'],$model->$slug)}}" method="POST" style="display: none;">
                {{ csrf_field() }}


                {{ method_field('delete') }}
            </form>
        @endif

        </div>
    </section>
    <!-- / main content -->


@stop




