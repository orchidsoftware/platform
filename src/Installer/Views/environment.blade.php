@extends('install::layouts.install')

@section('title', trans('install.environment.title'))
@section('container')



            @if (session('message'))
                <p class="alert alert-danger">{{ session('message') }}</p>
            @endif

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





            <div class="tab-content">
                <div class="tab-pane fade in active" role="tabpanel" id="simple" aria-labelledby="simple-tab">


                    @foreach($envArray as $key => $value)
                        <div class="form-group">
                            <label>{{$key}}</label>
                            <input class="form-control no-resize" rows="10" name="config[{{$key}}]" value="{{$value}}">
                        </div>
                    @endforeach

                </div>
                <div class="tab-pane fade" role="tabpanel" id="expert" aria-labelledby="expert-tab">

                    <form class="form" method="post" action="{{ route('install::environmentSave') }}">

                        <div class="form-group">
                            <label>.env</label>
                            <textarea class="form-control no-resize" rows="40" name="envConfig">{{ $envConfig }}</textarea>
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




            @if(!isset($environment['errors']))
                <div class="text-right">
                    <a href="{{ route('install::requirements') }}" class="btn btn-primary">
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


@stop