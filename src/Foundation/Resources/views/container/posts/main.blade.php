@extends('dashboard::layouts.dashboard')


@section('title',$name)




@section('content')



    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <h1 class="m-n font-thin h3 text-black">{{$name or '' }}</h1>
                <small class="text-muted">Welcome to angulr application</small>
            </div>
        </div>
    </div>
    <!-- / main header -->













@stop




