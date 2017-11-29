@extends('dashboard::layouts.dashboard')
@section('title',$type->name)
@section('description',$type->description)
@section('navbar')
    <ul class="nav navbar-nav navbar-right v-center">

            @if($locales->count() > 1)
            <li class="dropdown">
                <a href="#"
                   class="dropdown-toggle text-uppercase"
                   data-toggle="dropdown"
                   role="button"
                   aria-haspopup="true"
                   aria-expanded="false">
                    <i class="icon-globe m-r-xs"></i> <span id="code-local">{{key(reset($locales))}}</span>
                    <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">

                    @foreach($locales as $code => $lang)
                        <li>
                            <a data-target="#local-{{$code}}"
                               role="tab"
                               data-toggle="tab"
                               onclick="document.getElementById('code-local').innerHTML = '{{$code}}'"
                               aria-controls="local-{{$code}}"
                               aria-expanded="@if ($loop->first)true @else false @endif">{{$lang['native']}}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>
        @endif

        <li>
                <button type="submit"
                        form="post-form"
                        class="btn btn-sm btn-link"><i class="icon-check fa fa-2x"></i></button>
            </li>

        </ul>
@stop
@section('content')
    <div class="app-content-body app-content-full" id="post" data-post-id="{{$post->id}}">
        <!-- hbox layout  -->
        <form class="hbox hbox-auto-xs bg-light" id="post-form" method="post" action="{{route('dashboard.pages.update',[
        'type' => $type->slug,
        ])}}" enctype="multipart/form-data">
        @if(count($type->fields()) > 0)
            <!-- column  -->
                <div class="col  lter b-r">
                    <div class="vbox">
                        {{--Old locales
                        @if($locales->count() > 1)
                            <div class="nav-tabs-alt">
                                <ul class="nav nav-tabs nav-justified">
                                    @foreach($locales as $code => $lang)
                                        <li @if ($loop->first) class="active" @endif>
                                            <a data-target="#local-{{$code}}" role="tab" data-toggle="tab"
                                               aria-expanded="true">{{$lang['native']}}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        --}}
                        <div class="bg-white">
                            <div class="tab-content @if(!$type->checkModules()) container @endif">
                                @foreach($locales as $code => $lang)
                                    <div class="tab-pane @if ($loop->first) active  @endif" id="local-{{$code}}">
                                        <div class="wrapper-xl  bg-white">
                                            {!! $type->generateForm($code,$post) !!}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /column  -->
        @endif
        @if($type->checkModules())
            <!-- column  -->
                <div class="col wi-col lter b-r">
                    <div class="vbox">
                        <div class="nav-tabs-alt">
                            @if(count($type->render() ) > 1)
                                <ul class="nav nav-tabs">
                                @foreach($type->render() as $name => $view)
                                        <li @if ($loop->first) class="active" @endif>
                                        <a data-target="#module-{{str_slug($name)}}" role="tab" data-toggle="tab"
                                           aria-expanded="true">{{$name}}</a>
                                    </li>
                                    @endforeach
                            </ul>
                            @endif
                        </div>
                        <div class="row-row">
                            <div class="cell scrollable hover">
                                <div class="cell-inner">
                                    <div class="tab-content">
                                        @foreach($type->render() as $name => $view)
                                            <div class="tab-pane @if($loop->first) active @endif"
                                                 id="module-{{str_slug($name)}}">
                                                {!! $view !!}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /column  -->
            @endif
            {{ csrf_field() }}
            {{ method_field('PUT') }}
        </form>
        <!-- /hbox layout  -->
    </div>
@stop
