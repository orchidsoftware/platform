@extends('dashboard::layouts.dashboard')

@section('title','Roles Page')

@section('content')





    <!-- main header -->
    <header class="bg-light lter b-b wrapper-md">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <h1 class="m-n font-thin h3 text-black">Roles</h1>
                <small class="text-muted">Welcome to angulr application</small>
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
                            <i class="glyphicon glyphicon-user text-md text-muted wrapper-sm"></i>
                            {{$name}}
                        </a>
                    </li>

                @endforeach

            </ul>
        </div>



        <div class="tab-content">
            @foreach($forms as $name => $form)
                <div role="tabpanel" class="tab-pane @if ($loop->first) active @endif" id="tab-{{$name}}">
                    {!! $form !!}
                </div>
            @endforeach
        </div>


    </section>
    <!-- / main content -->


@stop




