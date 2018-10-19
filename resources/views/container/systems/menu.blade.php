@extends('platform::layouts.dashboard')


@section('title',__('Menu'))
@section('description',$name)
@section('controller','layouts--systems')

@section('navbar')
    <div class="text-right">
        <ul class="nav justify-content-end v-center">
            @if(count($locales) > 1)
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                       aria-haspopup="true"
                       aria-expanded="false">
                        <i class="icon-globe m-r-xs"></i>
                        {{$locales[$currentLocale]['native']}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        @foreach($locales as $code => $locale)
                            <a class="dropdown-item" href="?lang={{$code}}"
                               data-turbolinks-action="replace">
                                {{$locale['native']}}</a>
                        @endforeach
                    </div>
                </li>
            @endif

            @if(count($availableMenus) > 1)
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                       aria-haspopup="true"
                       aria-expanded="false">
                        <i class="icon-menu m-r-xs"></i> {{$availableMenus[$name]}}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        @foreach($availableMenus as $key => $value)
                                <a href="{{ route('platform.systems.menu.show',$key) }}"
                                   class="dropdown-item">{{ $value }}
                                </a>
                        @endforeach
                    </ul>
                </li>
            @endif

                <li class="dropdown nav-item">
                    <button class="btn btn-link dropdown-item" type="button" data-toggle="modal" data-target="#exampleModal">
                        <i class="icon-plus m-r-xs"></i> Add Element
                    </button>

                </li>
        </ul>
    </div>
@stop

@section('content')

    <div class=""
         data-controller="components--menu"
         data-content-loader-url="{{$name}}"
         data-components--menu-count="0"
         data-components--menu-id=""
    >


        <div class="wrapper">
                <div class="dd" data-lang="{{$currentLocale}}" data-name="{{$name}}">
                    <ol class="dd-list">
                        @include('platform::partials.menu.item',[
                            'menu'=>$menu
                        ])
                    </ol>
                </div>
        </div>



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Element Menu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="wrapper-md">

                            <div class="form">
                                <div class="form-group">
                                    <label>{{__('Name')}} <span
                                                class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control"
                                           data-target="components--menu.label"
                                           required
                                           placeholder="{{__('About us')}}">

                                    <small class="form-text text-danger none"
                                           id="errors.label">{{__('Please fill in the field.')}}</small>
                                </div>
                                <div class="form-group">
                                    <label>{{trans('platform::systems/menu.form.alt')}} <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control"
                                           data-target="components--menu.title"
                                           required
                                           placeholder="{{trans('platform::systems/menu.form.alt_description')}}">
                                    <small class="form-text text-danger none"
                                           id="errors.title">{{__('Please fill in the field.')}}</small>
                                </div>
                                <div class="form-group">
                                    <label>{{trans('platform::systems/menu.form.url')}} <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control"
                                           data-target="components--menu.slug"
                                           required
                                           placeholder="{{trans('platform::systems/menu.form.url_description')}}">
                                    <small class="form-text text-danger none"
                                           id="errors.slug">{{__('Please fill in the field.')}}</small>
                                </div>

                                <div class="form-group">
                                    <label>{{trans('platform::systems/menu.form.display.name')}}</label>
                                    <select class="form-control" data-target="components--menu.auth">
                                        <option value="0"
                                                selected>{{trans('platform::systems/menu.form.display.variables.no_auth')}}</option>
                                        <option value="1">{{trans('platform::systems/menu.form.display.variables.auth')}}</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>{{trans('platform::systems/menu.form.relations.name')}}</label>

                                    <select class="form-control" data-target="components--menu.robot">
                                        <option value=""></option>
                                        <option value="answer">{{trans('platform::systems/menu.form.relations.variables.answer')}}</option>
                                        <option value="chapter">{{trans('platform::systems/menu.form.relations.variables.chapter')}}</option>
                                        <option value="co-worker">{{trans('platform::systems/menu.form.relations.variables.co-worker')}}</option>
                                        <option value="colleague">{{trans('platform::systems/menu.form.relations.variables.colleague')}}</option>
                                        <option value="contact">{{trans('platform::systems/menu.form.relations.variables.contact')}}</option>
                                        <option value="details">{{trans('platform::systems/menu.form.relations.variables.details')}}</option>
                                        <option value="edit">{{trans('platform::systems/menu.form.relations.variables.edit')}}</option>
                                        <option value="friend">{{trans('platform::systems/menu.form.relations.variables.friend')}}</option>
                                        <option value="question">{{trans('platform::systems/menu.form.relations.variables.question')}}</option>
                                        <option value="archives">{{trans('platform::systems/menu.form.relations.variables.archives')}}</option>
                                        <option value="author">{{trans('platform::systems/menu.form.relations.variables.author')}}</option>
                                        <option value="bookmark">{{trans('platform::systems/menu.form.relations.variables.bookmark')}}</option>
                                        <option value="first">{{trans('platform::systems/menu.form.relations.variables.first')}}</option>
                                        <option value="help">{{trans('platform::systems/menu.form.relations.variables.help')}}</option>
                                        <option value="index">{{trans('platform::systems/menu.form.relations.variables.index')}}</option>
                                        <option value="last">{{trans('platform::systems/menu.form.relations.variables.last')}}</option>
                                        <option value="license">{{trans('platform::systems/menu.form.relations.variables.license')}}</option>
                                        <option value="me">{{trans('platform::systems/menu.form.relations.variables.me')}}</option>
                                        <option value="next">{{trans('platform::systems/menu.form.relations.variables.next')}}</option>
                                        <option value="nofollow">{{trans('platform::systems/menu.form.relations.variables.nofollow')}}</option>
                                        <option value="noreferrer">{{trans('platform::systems/menu.form.relations.variables.noreferrer')}}</option>
                                        <option value="prefetch">{{trans('platform::systems/menu.form.relations.variables.prefetch')}}</option>
                                        <option value="prev">{{trans('platform::systems/menu.form.relations.variables.prev')}}</option>
                                        <option value="search">{{trans('platform::systems/menu.form.relations.variables.search')}}</option>
                                        <option value="sidebar">{{trans('platform::systems/menu.form.relations.variables.sidebar')}}</option>
                                        <option value="tag">{{trans('platform::systems/menu.form.relations.variables.tag')}}</option>
                                        <option value="up">{{trans('platform::systems/menu.form.relations.variables.up')}}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>{{trans('platform::systems/menu.form.class')}}</label>
                                    <input type="text" class="form-control" data-target="components--menu.style" placeholder="red">
                                </div>
                                <div class="form-group">
                                    <label>{{trans('platform::systems/menu.form.target.name')}}</label>
                                    <select class="form-control" data-target="components--menu.target">
                                        <option value="_self"
                                                selected>{{trans('platform::systems/menu.form.target.variables.self')}}</option>
                                        <option value="_blank">{{trans('platform::systems/menu.form.target.variables.blank')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                            {{__('Close')}}
                        </button>

                        <button type="button" data-action="components--menu#remove"
                                class="btn btn-danger" id="menu.remove">
                            {{trans('platform::systems/menu.form.control.remove')}}
                        </button>

                        <button type="button" data-action="components--menu#clear"
                                class="btn btn-default" id="menu.reset">
                            {{trans('platform::systems/menu.form.control.reset')}}
                        </button>

                        <button type="button" data-action="components--menu#add"
                                class="btn btn-primary" id="menu.create">
                            {{trans('platform::systems/menu.form.control.create')}}
                        </button>

                        <button type="button" data-action="components--menu#save"
                                class="btn btn-primary" id="menu.save">
                            {{trans('platform::systems/menu.form.control.save')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>


    </div>





@stop
