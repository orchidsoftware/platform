@extends('dashboard::layouts.install')
@section('title', trans('dashboard::install.environment.title'))
@section('descriptions', trans('dashboard::install.environment.message'))

@section('container')


    <form class="form" id="env" method="post" action="{{ route('install::environmentSave') }}">

        @if (session('message'))
            <p class="alert alert-info">{{ session('message') }}</p>
        @endif

        <div class="form-group">
            <label>Environment Configuration</label>
            <textarea class="form-control  form-control-grey no-resize" rows="35"
                      name="envConfig">{{ $envConfig }}</textarea>
            {!! csrf_field() !!}
        </div>
    </form>



    <div class="text-right">

        <button
                @if(!isset($environment['errors']))
                class="btn btn-link"
                @else
                class="btn btn-danger disable" disabled
                @endif

                form="env"
                type="submit"> {{ trans('dashboard::install.next') }}</button>

    </div>

@stop
