@extends('platform::layouts.dashboard')
@section('title',$name)
@section('description',$description)
@section('navbar')

    <ul class="nav justify-content-end  v-center" role="tablist">
        <li class="nav-item">
            <button type="submit"
                    onclick="window.platform.validateForm('form-group','{{trans('platform::common.alert.validate')}}')"
                    form="form-group"
                    class="btn btn-link btn-save"><i
                        class="icon-check"></i> {{trans('platform::common.commands.save')}}</button>
        </li>
        <li class="nav-item">
            <button type="submit" form="form-group-remove" class="btn btn-link" @if($method == 'GET') disabled @endif><i
                        class="icon-trash"></i> {{trans('platform::common.commands.remove')}}</button>
        </li>

    </ul>
@stop
@section('content')

    @if(count($forms) > 1)
        <div class="nav-tabs-alt bg-white-only">
            <ul class="nav nav-tabs padder bg-light" role="tablist">
                @foreach($forms as $name => $form)
                    <li class="nav-item">
                        <a class="nav-link @if ($loop->first) active @endif" data-target="#tab-{{str_slug($name)}}"
                           role="tab" data-toggle="tab">
                            {!! $name !!}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- main content  -->
    <section>
        <div class="bg-white-only bg-auto no-border-xs">
            <form class="form-horizontal" id="form-group" action="{{route($route,$slug)}}" method="post"
                  enctype="multipart/form-data">
                <div class="tab-content">
                    @foreach($forms as $name => $form)
                        <div role="tabpanel" class="tab-pane @if ($loop->first) active @endif"
                             id="tab-{{str_slug($name)}}">
                            {!! $form !!}
                        </div>
                    @endforeach
                </div>
                @csrf
                @method($method)
            </form>
            <form id="form-group-remove" action="{{route($route,$slug)}}" method="POST">
                @csrf
                @method('delete')
            </form>
        </div>
    </section>
    <!-- / main content  -->
@stop
