@extends('dashboard::layouts.dashboard')


@section('title',$name)
@section('description',$description)




@section('navbar')
    <div class="col-sm-6 col-xs-12 text-right">
        <div class="btn-group" role="group" aria-label="...">
            <button type="submit" form="form-group" class="btn btn-link"><i class="icon-check fa fa-2x"></i></button>
        </div>
    </div>
@stop


@section('content')


    <!-- main content  -->
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


            <form class="form-horizontal" action="{{route('dashboard.systems.settings')}}" id="form-group"
                  method="post">

                <div class="tab-content">
                    @foreach($forms as $name => $form)
                        <div role="tabpanel" class="tab-pane @if ($loop->first) active @endif" id="tab-{{str_slug($name)}}">
                            {!! $form !!}
                        </div>
                    @endforeach
                </div>


                {{ csrf_field() }}

            </form>
        </div>
    </section>
    <!-- / main content  -->


@stop




