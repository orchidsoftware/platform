@extends('platform::layouts.dashboard')


@section('title',trans('platform::systems/menu.title'))
@section('description',$nameMenu)


@section('navbar')
    <div class="text-right">
        <ul class="nav justify-content-end">
            @if(count($locales) > 1)
                <li class="dropdown nav-item">
                    <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button"
                       aria-haspopup="true"
                       aria-expanded="false">{{$locales[$currentLocale]['native']}} </a>
                    <ul class="dropdown-menu dropdown-menu-right">

                        @foreach($locales as $code => $locale)
                            @if($currentLocale == $code)
                                <li class="disabled">
                                    <a class="dropdown-item">{{$locale['native']}}</a>
                                </li>
                            @else
                                <li>
                                    <a class="dropdown-item" href="?lang={{$code}}"
                                       data-turbolinks-action="replace">{{$locale['native']}}</a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </li>
            @endif
        </ul>
    </div>
@stop



@section('content')


    <div class="hbox hbox-auto-xs hbox-auto-sm" id="menu-vue">

        <div class="hbox-col w-xxl bg-white-only b-r bg-auto no-border-xs">

            <div class="wrapper-md">

                <div class="form">
                    <div class="form-group">
                        <label>{{trans('platform::systems/menu.form.title')}} <span
                                    class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control"
                               v-model="label"
                               required
                               placeholder="{{trans('platform::systems/menu.form.title_description')}}">

                        <small class="form-text text-danger"
                               v-if="errors.label">{{trans('platform::common.validation.required')}}</small>
                    </div>
                    <div class="form-group">
                        <label>{{trans('platform::systems/menu.form.alt')}} <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" v-model="title"
                               required
                               placeholder="{{trans('platform::systems/menu.form.alt_description')}}">
                        <small class="form-text text-danger"
                               v-if="errors.title">{{trans('platform::common.validation.required')}}</small>
                    </div>
                    <div class="form-group">
                        <label>{{trans('platform::systems/menu.form.url')}} <span class="text-danger">*</span></label>
                        <input type="text"
                               class="form-control"
                               v-model="slug"
                               required
                               placeholder="{{trans('platform::systems/menu.form.url_description')}}">
                        <small class="form-text text-danger"
                               v-if="errors.slug">{{trans('platform::common.validation.required')}}</small>
                    </div>

                    <div class="form-group">
                        <label>{{trans('platform::systems/menu.form.display.name')}}</label>
                        <select class="form-control" v-model="auth">
                            <option value="0"
                                    selected>{{trans('platform::systems/menu.form.display.variables.no_auth')}}</option>
                            <option value="1">{{trans('platform::systems/menu.form.display.variables.auth')}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{trans('platform::systems/menu.form.relations.name')}}</label>

                        <select class="form-control" v-model="robot">
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
                        <input type="text" class="form-control" v-model="style" placeholder="red">
                    </div>
                    <div class="form-group">
                        <label>{{trans('platform::systems/menu.form.target.name')}}</label>
                        <select class="form-control" v-model="target">
                            <option value="_self"
                                    selected>{{trans('platform::systems/menu.form.target.variables.self')}}</option>
                            <option value="_blank">{{trans('platform::systems/menu.form.target.variables.blank')}}</option>
                        </select>

                    </div>


                </div>


                <div class="text-center">
                    
                    <div class="btn-group btn-group-sm w-full" role="group">

                        <button type="button" v-on:click="remove()" v-if="exist()"
                                class="btn w-full btn-danger">
                            {{trans('platform::systems/menu.form.control.remove')}}
                        </button>

                        <button type="button" v-on:click="clear()" v-if="exist()"
                                class="btn w-full btn-default">
                            {{trans('platform::systems/menu.form.control.reset')}}
                        </button>

                        <button type="button" v-on:click="add()" v-if="!exist()"
                                class="btn w-full btn-primary">
                            {{trans('platform::systems/menu.form.control.create')}}
                        </button>

                        <button type="button" v-on:click="save()" v-if="exist()"
                                class="btn w-full btn-primary">
                            {{trans('platform::systems/menu.form.control.save')}}
                        </button>

                    </div>
                </div>


            </div>

        </div>


        <div class="hbox-col">
            <div class="wrapper-md">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="dd" data-lang="{{$currentLocale}}" data-name="{{$nameMenu}}">
                            <ol class="dd-list">
                                @include('platform::partials.menu.item',[
                                    'menu'=>$menu
                                ])
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
