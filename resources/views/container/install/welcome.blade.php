@extends('dashboard::layouts.install')

@section('title', trans('dashboard::install.welcome.title'))
@section('descriptions', trans('dashboard::install.welcome.message'))

@section('container')



    <h4 class="m-b font-thin b-b b-light-cs wrapper-xs">
        {{ trans('dashboard::install.welcome.message') }}
    </h4>

    <p class="text-justify">
        {{ trans('dashboard::install.welcome.body') }}

    </p>

    <p class="text-justify">
        {{ trans('dashboard::install.welcome.footer') }}
    </p>



    <div class="row m-t-xl m-b-md wrapper-xs v-center block-xs">
        <div class="col-sm-6 col-xs-12 b-r b-light">
            <p class="text-xs">
                The MIT License (MIT) Copyright <br>© Chernyaev Alexandr
            </p>
        </div>
        <div class="col-sm-6 col-xs-12 text-right"><a href="{{ route('install::environment') }}"
                                                      class="btn btn-link text-ellipsis"> <span
                        class="text-md text-ellipsis">{{ trans('dashboard::install.next') }}</span></a>
        </div>
    </div>




@stop
