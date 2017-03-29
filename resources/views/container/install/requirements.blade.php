@extends('dashboard::layouts.install')

@section('title', trans('dashboard::install.requirements.title'))
@section('descriptions', trans('dashboard::install.requirements.message'))

@section('container')


    <ul class="list-group center wrapper">
        @foreach($requirements['requirements'] as $extention => $enabled)
            <li class="m-b-sm">
                {{ $extention }}

                @if($enabled)
                    <i class="fa fa-check text-success pull-right" aria-hidden="true"></i>
                @else
                    <i class="fa fa-times text-danger pull-right" aria-hidden="true"></i>
                @endif
            </li>
        @endforeach
    </ul>


    <div class="text-right">
        <a href="{{ route('install::permissions') }}"
           @if(!isset($requirements['errors']))
           class="btn btn-link"
           @else
           class="btn btn-danger disable" disabled
                @endif
        >

            {{ trans('dashboard::install.next') }} <i
                    class="ion-ios-arrow-right m-l-xs"> </i>
        </a>
    </div>


@stop