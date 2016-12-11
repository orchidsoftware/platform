@extends('install::layouts.install')

@section('title', trans('install.permissions.title'))
@section('descriptions', trans('install.permissions.message'))

@section('container')



<ul class="list-group center wrapper">
    @foreach($permissions['permissions'] as $permission)
        <li class="m-b-sm">
            <span class="font-thin">{{ $permission['folder'] }}</span> -
            {{ $permission['permission'] }}

            @if($permission['isSet'])
                <i class="fa fa-check text-success pull-right" aria-hidden="true"></i>
            @else
                <i class="fa fa-times text-danger pull-right" aria-hidden="true"></i>
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
            {{ trans('install.next') }} <i
                    class="ion-ios-arrow-right m-l-xs"> </i>
        </a>
    </div>



@stop