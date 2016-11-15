@extends('dashboard::layouts.install')

@section('title', trans('install.environment.title'))
@section('container')

    <div class="install-body container w-xxl padder-lg">
        <div class="panel panel-default wrapper-sm">
            <div class="panel-body">

                @if (session('message'))
                    <p class="alert alert-danger">{{ session('message') }}</p>
                @endif


                <form class="form" method="post" action="{{ route('dashboard::environmentSave') }}">
                    <div class="form-group">
                        <label>Текст</label>
                    <textarea class="form-control no-resize" rows="10" name="envConfig">{{ $envConfig }}</textarea>
                    {!! csrf_field() !!}
                        </div>
                    <div class="form-group">
                    <div class="text-right">
                        <button class="btn btn-default btn-sm" type="submit">{{ trans('install.environment.save') }}</button>
                    </div>
                    </div>
                </form>


                @if(!isset($environment['errors']))
                    <div class="text-right">
                        <a href="{{ route('dashboard::requirements') }}" class="btn btn-primary">
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
