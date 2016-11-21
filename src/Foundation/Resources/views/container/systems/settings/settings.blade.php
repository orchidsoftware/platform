@extends('dashboard::layouts.dashboard')


@section('title','Settings Page')




@section('content')





    <!-- main header -->
    <header class="bg-light lter b-b wrapper-md">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <h1 class="m-n font-thin h3 text-black">{{$name or ''}}</h1>
                <small class="text-muted">{{$description or ''}}</small>
            </div>


            <div class="col-sm-6 col-xs-12 text-right">
                <div class="btn-group" role="group" aria-label="...">
                    <button type="submit" form="form-group" class="btn btn-link"><i class="ion-ios-compose-outline fa fa-2x"></i></button>
                </div>
            </div>

        </div>
    </header>
    <!-- / main header -->


    <!-- main content -->
    <section class="bg-white-only b-l bg-auto no-border-xs">
        <div class="nav-tabs-alt">
            <ul class="nav nav-tabs" role="tablist">


                @foreach($forms as $name => $form)
                <li @if ($loop->first) class="active" @endif>
                    <a data-target="#tab-{{$name}}" role="tab" data-toggle="tab">
                        {{$name}}
                    </a>
                </li>
                @endforeach

            </ul>
        </div>


        <form class="form-horizontal" action="{{route('dashboard.systems.settings')}}" id="form-group" method="post">

        <div class="tab-content">
            @foreach($forms as $name => $form)
                <div role="tabpanel" class="tab-pane @if ($loop->first) active @endif" id="tab-{{$name}}">
                    {!! $form !!}
                </div>
            @endforeach
        </div>


            {{ csrf_field() }}

        </form>

    </section>
    <!-- / main content -->


@stop




