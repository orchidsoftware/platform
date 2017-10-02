@extends('dashboard::layouts.install')

@section('title', trans('dashboard::install.requirements.title'))
@section('descriptions', trans('dashboard::install.requirements.message'))

@section('container')


    <label>Server Requirements</label>
    <ul class="list-group center wrapper">
        @foreach($requirements['requirements'] as $extension => $enabled)
            <li class="m-b-sm">
                {{ trans('dashboard::install.requirements.extensions.'. $extension) }}

                @if($enabled)
                    <i class="icon-check text-success pull-right" aria-hidden="true"></i>
                @else
                    <i class="icon-close text-danger pull-right" aria-hidden="true"></i>
                @endif
            </li>
        @endforeach
    </ul>


    <div class="text-right">
        <a
           @if(!isset($requirements['errors']))
           href="{{ route('install::permissions') }}"
           class="btn btn-link"
           @else
           href="#"
           class="btn btn-danger disable" disabled
                @endif
        >

            {{ trans('dashboard::install.next') }}
        </a>
    </div>


@stop
