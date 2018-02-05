@extends('dashboard::layouts.dashboard')
@section('title',$name)
@section('description',$description)
@section('navbar')
    <div class="text-right">
        <div class="btn-group" role="group" aria-label="...">
            <button type="submit"
                    onclick="window.dashboard.validateForm('form-group','{{trans('dashboard::common.alert.validate')}}')"
                    form="form-group"
                    class="btn btn-link btn-save"><i class="sli icon-check fa-2x"></i></button>
            <button type="submit" form="form-group-remove" class="btn btn-link" @if($method == 'GET') disabled @endif><i
                        class="sli icon-trash fa-2x"></i></button>
        </div>
    </div>
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
                {{csrf_field()}}
                {{ method_field($method)}}
            </form>
            <form id="form-group-remove" action="{{route($route,$slug)}}" method="POST">
                {{ csrf_field() }}
                {{ method_field('delete') }}
            </form>
        </div>
    </section>
    <!-- / main content  -->
@stop
