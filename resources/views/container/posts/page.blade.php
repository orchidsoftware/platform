@extends('platform::layouts.dashboard')
@section('title',$type->name)
@section('description',$type->description)
@section('navbar')
    <ul class="nav justify-content-end v-center">

        @if($locales->count() > 1)
            <li class="nav-item dropdown">
                <a href="#"
                   class="btn btn-link text-uppercase"
                   data-toggle="dropdown"
                   role="button"
                   aria-haspopup="true"
                   aria-expanded="false">
                    <i class="icon-globe m-r-xs"></i> <span id="code-local">{{key(reset($locales))}}</span>

                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    @foreach($locales as $code => $lang)
                        <a class="dropdown-item" data-target="#local-{{$code}}"
                           role="tab"
                           data-toggle="tab"
                           onclick="document.getElementById('code-local').innerHTML = '{{$code}}'"
                           aria-controls="local-{{$code}}"
                           aria-expanded="@if ($loop->first)true @else false @endif">{{$lang['native']}}
                        </a>
                    @endforeach
                </div>
            </li>
        @endif

        <li class="nav-item">
            <button type="submit"
                    onclick="window.platform.validateForm('post-form','{{trans('platform::common.alert.validate')}}')"
                    form="post-form"
                    class="btn btn-link"><i class="icon-check"></i> {{trans('platform::common.commands.save')}}
            </button>
        </li>

    </ul>
@stop


@section('content')
    <div id="post" data-post-id="{{$post->id}}">
        <!-- hbox layout -->
        <form class="hbox hbox-auto-xs no-gutters" id="post-form" method="post" action="{{route('platform.pages.update',[
        'type' => $type->slug,
        ])}}" enctype="multipart/form-data">
        @if(count($type->fields()) > 0)
            <!-- column -->
                <div class="hbox-col lter">
                    <div class="vbox">
                        <div class="wrapper-lg">
                            <div class="tab-content">
                                @foreach($locales as $code => $lang)
                                    <div class="tab-pane @if ($loop->first) active @endif" id="local-{{$code}}">
                                        {!! generate_form($type->fields(), $post->toArray(), $code, 'content') !!}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /column -->
        @endif
        <!-- column -->
            <div class="hbox-col wi-col lter">
                <div class="vbox">
                    <div class="row-row">
                        <div class="wrapper-lg">
                            {!! generate_form($type->main(), $post->toArray()) !!}
                            {!! generate_form($type->options(), $post->getOptions()->toArray(), null, 'options') !!}

                            @include('platform::container.posts.locale')
                        </div>
                    </div>
                </div>
            </div>
            <!-- /column -->
            @csrf
            @method('PUT')
        </form>
        <!-- /hbox layout -->
    </div>
@stop
