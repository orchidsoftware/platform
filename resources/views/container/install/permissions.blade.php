@extends('dashboard::layouts.install')

@section('title', trans('dashboard::install.permissions.title'))
@section('descriptions', trans('dashboard::install.permissions.message'))

@section('container')


    <label>File permission</label>
    <ul class="list-group center wrapper">
        @foreach($permissions['permissions'] as $permission)
            <li class="m-b-sm">
                <span class="font-thin">{{ $permission['folder'] }}</span> -
                {{ $permission['permission'] }}

                @if($permission['isSet'])
                    <i class="icon-check text-success pull-right" aria-hidden="true"></i>
                @else
                    <i class="icon-close text-danger pull-right" aria-hidden="true"></i>
                @endif
            </li>
        @endforeach
    </ul>


    <div class="text-right">
        <a
                @if(!isset($permissions['errors']))
                href="{{ route('install::database') }}" class="btn btn-link"
                @else
                href="#" class="btn btn-danger disable" disabled
                @endif
        >
            {{ trans('dashboard::install.next') }}
        </a>
    </div>



@stop
