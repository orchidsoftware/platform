@extends('dashboard::layouts.install')

@section('title', trans('install.permissions.title'))
@section('container')


    <div class="install-body container w-xxl padder-lg">
        <div class="panel panel-default wrapper-sm">
            <div class="panel-body">


                <ul class="list-group center wrapper">
                    @foreach($permissions['permissions'] as $permission)
                        <li class="m-b-sm">
                            {{ $permission['folder'] }} -
                            {{ $permission['permission'] }}

                            @if($permission['isSet'])
                                <i class="fa fa-check text-success pull-right" aria-hidden="true"></i>
                            @else
                                <i class="fa fa-times text-danger pull-right" aria-hidden="true"></i>
                            @endif
                        </li>
                    @endforeach
                </ul>

                @if(!isset($permissions['errors']))
                    <div class="text-right">
                        <a href="{{ route('dashboard::database') }}" class="btn btn-primary">
                            {{ trans('install.next') }}
                        </a>
                    </div>
                @else
                    <div class="text-right">
                        <a href="#" class="btn btn-danger disable" disabled>
                            {{ trans('install.next') }}
                        </a>
                    </div>
                @endif


            </div>
        </div>
    </div>


@stop
