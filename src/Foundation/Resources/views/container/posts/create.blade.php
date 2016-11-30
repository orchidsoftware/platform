@extends('dashboard::layouts.dashboard')


@section('title',$type->name)




@section('content')


    <div class="app-content-body app-content-full">


        @if (count($errors) > 0)
            <div class="alert alert-danger m-n">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


    <!-- hbox layout -->
        <form class="hbox hbox-auto-xs bg-light" method="post"
              action="{{route('dashboard.posts.type.store',['type' => $type->slug])}}" enctype="multipart/form-data">


            <!-- column -->
            <div class="col w lter b-r">
                <div class="vbox">
                    <div class="wrapper b-b">
                        <h4 class="font-thin">{{$type->name or '' }}</h4>

                        <div class="btn-group btn-group-sm" role="group" aria-label="...">
                            <button type="submit" class="btn btn-link"><i class="ion-ios-compose-outline fa fa-2x"></i>
                            </button>
                        </div>
                        {{ csrf_field() }}
                    </div>
                    <div class="nav-tabs-alt">
                        <ul class="nav nav-tabs nav-justified">
                            @foreach($locales as $code => $lang)
                                <li @if ($loop->first) class="active" @endif>
                                    <a data-target="#local-{{$code}}" role="tab" data-toggle="tab"
                                       aria-expanded="true">{{$lang['native']}}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="row-row">
                        <div class="cell scrollable hover">
                            <div class="cell-inner bg-white">
                                <div class="tab-content">
                                    @foreach($locales as $code => $lang)
                                        <div class="tab-pane @if ($loop->first) active  @endif" id="local-{{$code}}">
                                            <div class="wrapper-md">
                                                {!! $type->generateForm($code) !!}
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /column -->


        @if($type->checkModules())


            <!-- column -->
                <div class="col w lter b-r">
                    <div class="vbox">
                        <div class="nav-tabs-alt">
                            <ul class="nav nav-tabs nav-justified">
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
                <!-- /column -->
            @endif


        </form>
        <!-- /hbox layout -->


    </div>













@stop




