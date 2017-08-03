@extends('dashboard::layouts.dashboard')
@section('title',$type->name)
@section('description',$type->description)
@section('navbar')
    <div class="col-md-6 no-padder text-right">
        <div class="btn-group btn-group-sm" role="group" aria-label="...">
            <button type="submit" form="post-form" class="btn btn-link"><i class="icon-check fa fa-2x"></i>
            </button>
        </div>
    </div>
@stop
@section('content')
    <div class="app-content-body app-content-full" id="post">
        @if (count($errors) > 0)
            <div class="alert alert-danger m-n">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    @endif
    <!-- hbox layout  -->
        <form class="hbox hbox-auto-xs bg-light" id="post-form" method="post"
              action="{{route('dashboard.posts.type.store',['type' => $type->slug])}}" enctype="multipart/form-data">
        @if(count($type->fields()) > 0)
            <!-- column  -->
                <div class="col lter b-r">
                    <div class="vbox">
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
                        <div class="bg-white">
                            <div class="tab-content">
                                @foreach($locales as $code => $lang)
                                    <div class="tab-pane @if ($loop->first) active  @endif" id="local-{{$code}}">
                                        <div class="wrapper-xl bg-white">
                                            {!! $type->generateForm($code) !!}
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
                            <ul class="nav nav-tabs">
                                @foreach($type->render() as $name => $view)
                                    <li @if ($loop->first) class="active" @endif>
                                        <a data-target="#module-{{$loop->iteration}}" role="tab" data-toggle="tab"
                                           aria-expanded="true">{{$name}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="row-row">
                            <div class="cell scrollable hover">
                                <div class="cell-inner">
                                    <div class="tab-content">
                                        @foreach($type->render() as $name => $view)
                                            <div class="tab-pane @if($loop->first) active @endif"
                                                 id="module-{{$loop->iteration}}">
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
        </form>
        <!-- /hbox layout  -->
    </div>
@stop
