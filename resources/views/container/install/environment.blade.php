@extends('dashboard::layouts.install')
@section('title', trans('dashboard::install.environment.title'))
@section('descriptions', trans('dashboard::install.environment.message'))

@section('container')




    {{--
        <div class="nav-tabs-alt bg-white m-b-md">
            <ul class="nav nav-tabs nav-justified" role="tablist">
                <li class="active">
                    <a data-target="#simple" role="tab" data-toggle="tab">
                        <i class="fa fa-cogs text-md text-muted wrapper-sm"></i>
                        <span class="text-muted">Simple Settings</span>
                    </a>
                </li>
                <li>
                    <a data-target="#expert" role="tab" data-toggle="tab">
                        <i class="fa fa-wrench text-md text-muted wrapper-sm"></i>
                        <span class="text-muted">Expert Settings</span>
                    </a>
                </li>
            </ul>
        </div>
    --}}



    {{--
                <div class="tab-content">
                    <div class="tab-pane fade in active" role="tabpanel" id="simple" aria-labelledby="simple-tab">


                        @foreach($envArray as $key => $value)
                            <div class="form-group">
                                <label>{{$key}}</label>
                                <input class="form-control form-control-grey no-resize"  name="config[{{$key}}]" value="{{$value}}">
                            </div>
                        @endforeach

                    </div>
                    <div class="tab-pane fade" role="tabpanel" id="expert" aria-labelledby="expert-tab">

                        <form class="form" method="post" action="{{ route('install::environmentSave') }}">

                            <div class="form-group">
                                <label>.env</label>
                                <textarea class="form-control  form-control-grey no-resize" rows="40" name="envConfig">{{ $envConfig }}</textarea>
                                {!! csrf_field() !!}
                            </div>
                            <div class="form-group">
                                <div class="text-right">
                                    <button class="btn btn-default btn-sm"
                                            type="submit">{{ trans('install.environment.save') }}</button>
                                </div>
                            </div>
                        </form>



                    </div>
                </div>
    --}}



    <form class="form" id="env" method="post" action="{{ route('install::environmentSave') }}">

        @if (session('message'))
            <p class="alert alert-info">{{ session('message') }}</p>
        @endif

        <div class="form-group">
            <label>.env</label>
            <textarea class="form-control  form-control-grey no-resize" rows="40"
                      name="envConfig">{{ $envConfig }}</textarea>
            {!! csrf_field() !!}
        </div>
    </form>





    <div class="row">
        <div class="col-md-6">
            <button class="btn btn-default btn-sm" form="env"
                    type="submit">{{ trans('dashboard::install.environment.save') }}</button>
        </div>

        <div class="col-md-6 text-right">
            <a href="{{ route('install::requirements') }}"
               @if(!isset($environment['errors']))
               class="btn btn-link"
               @else
               class="btn btn-danger disable" disabled
                    @endif
            >
                {{ trans('dashboard::install.next') }} <i
                        class="ion-ios-arrow-right m-l-xs"></i>
            </a>
        </div>
    </div>



@stop
