@extends('dashboard::layouts.dashboard')
@section('title',$name)
@section('description',$description)


@section('navbar')

    <div class="col-md-6">


        <ul class="nav navbar-nav navbar-right v-center">


            @foreach($commands as $command)
            <li>
                <button type="submit" formaction="{{$command['method'] or ''}}" form="post-form" class="btn btn-sm btn-link"><i class="{{$command['icon'] or ''}}"></i>{{$command['displayName'] or ''}}</button>
            </li>
            @endforeach



        </ul>

    </div>


@stop

@section('content')


@stop
