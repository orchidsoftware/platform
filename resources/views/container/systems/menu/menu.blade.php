@extends('dashboard::layouts.dashboard')


@section('title',trans('dashboard::systems/menu.title'))
@section('description',$nameMenu)


@section('navbar')
<div class="text-right">
    <ul class="nav justify-content-end">
        @if(count($locales) > 1)
            <li class="dropdown nav-item">
            <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown" role="button" aria-haspopup="true"
               aria-expanded="false">{{$locales[$currentLocale]['native']}} <span class="caret"></span></a>
            <ul class="dropdown-menu dropdown-menu-right">

                @foreach($locales as $code => $locale)
                    @if($currentLocale == $code)
                        <li class="disabled">
                            <a class="dropdown-item">{{$locale['native']}}</a>
                        </li>
                    @else
                        <li>
                            <a class="dropdown-item" href="?lang={{$code}}" data-turbolinks-action="replace">{{$locale['native']}}</a>
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
                        <label>{{trans('dashboard::systems/menu.form.title')}}</label>
                        <input type="text"
                               class="form-control"
                               v-model="label"
                               placeholder="{{trans('dashboard::systems/menu.form.title_description')}}">
                    </div>
                    <div class="form-group">
                        <label>{{trans('dashboard::systems/menu.form.alt')}}</label>
                        <input type="text" class="form-control" v-model="title"
                               placeholder="{{trans('dashboard::systems/menu.form.alt_description')}}">
                    </div>
                    <div class="form-group">
                        <label>{{trans('dashboard::systems/menu.form.url')}}</label>
                        <input type="text"
                               class="form-control"
                               v-model="slug"
                               placeholder="{{trans('dashboard::systems/menu.form.url_description')}}">
                    </div>

                    <div class="form-group">
                        <label>{{trans('dashboard::systems/menu.form.display.name')}}</label>
                        <select class="form-control" v-model="auth">
                            <option value="0"
                                    selected>{{trans('dashboard::systems/menu.form.display.variables.no_auth')}}</option>
                            <option value="1">{{trans('dashboard::systems/menu.form.display.variables.auth')}}</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>{{trans('dashboard::systems/menu.form.relations.name')}}</label>

                        <select class="form-control" v-model="robot">
                            <option value=""></option>
                            <option value="answer">{{trans('dashboard::systems/menu.form.relations.variables.answer')}}</option>
                            <option value="chapter">{{trans('dashboard::systems/menu.form.relations.variables.chapter')}}</option>
                            <option value="co-worker">{{trans('dashboard::systems/menu.form.relations.variables.co-worker')}}</option>
                            <option value="colleague">{{trans('dashboard::systems/menu.form.relations.variables.colleague')}}</option>
                            <option value="contact">{{trans('dashboard::systems/menu.form.relations.variables.contact')}}</option>
                            <option value="details">{{trans('dashboard::systems/menu.form.relations.variables.details')}}</option>
                            <option value="edit">{{trans('dashboard::systems/menu.form.relations.variables.edit')}}</option>
                            <option value="friend">{{trans('dashboard::systems/menu.form.relations.variables.friend')}}</option>
                            <option value="question">{{trans('dashboard::systems/menu.form.relations.variables.question')}}</option>
                            <option value="archives">{{trans('dashboard::systems/menu.form.relations.variables.archives')}}</option>
                            <option value="author">{{trans('dashboard::systems/menu.form.relations.variables.author')}}</option>
                            <option value="bookmark">{{trans('dashboard::systems/menu.form.relations.variables.bookmark')}}</option>
                            <option value="first">{{trans('dashboard::systems/menu.form.relations.variables.first')}}</option>
                            <option value="help">{{trans('dashboard::systems/menu.form.relations.variables.help')}}</option>
                            <option value="index">{{trans('dashboard::systems/menu.form.relations.variables.index')}}</option>
                            <option value="last">{{trans('dashboard::systems/menu.form.relations.variables.last')}}</option>
                            <option value="license">{{trans('dashboard::systems/menu.form.relations.variables.license')}}</option>
                            <option value="me">{{trans('dashboard::systems/menu.form.relations.variables.me')}}</option>
                            <option value="next">{{trans('dashboard::systems/menu.form.relations.variables.next')}}</option>
                            <option value="nofollow">{{trans('dashboard::systems/menu.form.relations.variables.nofollow')}}</option>
                            <option value="noreferrer">{{trans('dashboard::systems/menu.form.relations.variables.noreferrer')}}</option>
                            <option value="prefetch">{{trans('dashboard::systems/menu.form.relations.variables.prefetch')}}</option>
                            <option value="prev">{{trans('dashboard::systems/menu.form.relations.variables.prev')}}</option>
                            <option value="search">{{trans('dashboard::systems/menu.form.relations.variables.search')}}</option>
                            <option value="sidebar">{{trans('dashboard::systems/menu.form.relations.variables.sidebar')}}</option>
                            <option value="tag">{{trans('dashboard::systems/menu.form.relations.variables.tag')}}</option>
                            <option value="up">{{trans('dashboard::systems/menu.form.relations.variables.up')}}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{trans('dashboard::systems/menu.form.class')}}</label>
                        <input type="text" class="form-control" v-model="style" placeholder="red">
                    </div>
                    <div class="form-group">
                        <label>{{trans('dashboard::systems/menu.form.target.name')}}</label>
                        <select class="form-control" v-model="target">
                            <option value="_self"
                                    selected>{{trans('dashboard::systems/menu.form.target.variables.self')}}</option>
                            <option value="_blank">{{trans('dashboard::systems/menu.form.target.variables.blank')}}</option>
                        </select>

                    </div>


                </div>


                <div class="text-center">


                    <div class="btn-group btn-group-sm  btn-group-justified" role="group" aria-label="...">


                        <div class="btn-group" role="group" v-if="exist()">
                            <button type="button" v-on:click="remove()"
                                    class="btn btn-sm btn-danger padder-md m-b text-ellipsis"
                                    data-dismiss="modal">{{trans('dashboard::systems/menu.form.control.remove')}}

                            </button>
                        </div>

                        <div class="btn-group" role="group" v-if="exist()">
                            <button type="button" v-on:click="clear()"
                                    class="btn btn-sm btn-default padder-md m-b text-ellipsis"
                                    data-dismiss="modal">{{trans('dashboard::systems/menu.form.control.reset')}}
                            </button>

                        </div>

                        <div class="btn-group" role="group" v-if="!exist()">
                            <button type="button" v-on:click="add()"
                                    class="btn btn-sm btn-primary padder-md m-b text-ellipsis">{{trans('dashboard::systems/menu.form.control.create')}}
                            </button>
                        </div>

                        <div class="btn-group" role="group" v-if="exist()">
                            <button type="button" v-on:click="save()"
                                    class="btn btn-sm btn-primary padder-md m-b text-ellipsis">{{trans('dashboard::systems/menu.form.control.save')}}
                            </button>
                        </div>

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
                        @include('dashboard::partials.menu.item',[
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
