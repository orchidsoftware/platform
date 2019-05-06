@extends('platform::layouts.dashboard')

@section('title',__('Menu'))
@section('description',$name)
@section('controller','components--menu')
@section('controller-data',"
         data-content-loader-url='$name'
         data-components--menu-count='0'
         data-components--menu-id=''
")

@section('navbar')
    <div class="text-right">
        <ul class="nav justify-content-sm-end justify-content-start v-center">
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
                        <i class="icon-menu m-r-xs"></i> {{ __($availableMenus[$name]) }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                        @foreach($availableMenus as $key => $value)
                            <a href="{{ route('platform.systems.menu.show',$key) }}"
                               class="dropdown-item">{{ __($value) }}
                            </a>
                        @endforeach
                    </ul>
                </li>
            @endif

            <li class="dropdown nav-item">
                <button class="btn btn-link dropdown-item" type="button"
                        data-action="components--menu#clear"
                        data-toggle="modal"
                        data-target="#menuModal">
                    <i class="icon-plus m-r-xs"></i> {{ __('Add element') }}
                </button>

            </li>
        </ul>
    </div>
@stop

@section('content')

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
    <div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h5 class="modal-title">{{ __('Element settings') }}</h5>
                </div>
                <div class="modal-body">
                    <div class="form">
                            <div class="form-group">
                                <label>{{ __('Name') }} <span
                                            class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       data-target="components--menu.label"
                                       required
                                       placeholder="{{ __('About us') }}">

                                <small class="form-text text-danger none"
                                       id="errors.label">{{ __('Please fill in the field.') }}</small>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Alternative text') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control"
                                       data-target="components--menu.title"
                                       required
                                       placeholder="{{ __('History of the company') }}">
                                <small class="form-text text-danger none"
                                       id="errors.title">{{ __('Please fill in the field.') }}</small>
                            </div>
                            <div class="form-group">
                                <label>{{ __('URL') }} <span class="text-danger">*</span></label>
                                <input type="text"
                                       class="form-control"
                                       data-target="components--menu.slug"
                                       required
                                       placeholder="{{ __('/about') }}">
                                <small class="form-text text-danger none"
                                       id="errors.slug">{{ __('Please fill in the field.') }}</small>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Display') }}</label>
                                <select class="form-control" data-target="components--menu.auth">
                                    <option value="0"
                                            selected>{{ __('Visible to everyone') }}</option>
                                    <option value="1">{{ __('Only identified users') }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>{{ __('Relations') }}</label>

                                <select class="form-control" data-target="components--menu.robot">
                                    <option value=""></option>
                                    <option value="answer">{{ __('Answer to the question') }}</option>
                                    <option value="chapter">{{ __('Section or chapter of the current document') }}</option>
                                    <option value="co-worker">{{ __("Link to a colleague's page") }}</option>
                                    <option value="colleague">{{ __("Link to a colleague's page (not at work)") }}</option>
                                    <option value="contact">{{ __('Link to the page with contact information') }}</option>
                                    <option value="details">{{ __('Link to page with details') }}</option>
                                    <option value="edit">{{ __('Editable version of the current document') }}</option>
                                    <option value="friend">{{ __('Link to friend page') }}</option>
                                    <option value="question">{{ __('Question') }}</option>
                                    <option value="archives">{{ __('Link to the site archive') }}</option>
                                    <option value="author">{{ __('Link to the page about the author on the same domain') }}</option>
                                    <option value="bookmark">{{ __('Permanent link to a section or entry') }}</option>
                                    <option value="first">{{ __('Link to the first page') }}</option>
                                    <option value="help">{{ __('Link to a document with help') }}</option>
                                    <option value="index">{{ __('Link to content') }}</option>
                                    <option value="last">{{ __('Link to the last page') }}</option>
                                    <option value="license">{{ __('Link to a page with a license agreement or copyrights') }}</option>
                                    <option value="me">{{ __('Link to author page on another domain') }}</option>
                                    <option value="next">{{ __('Link to next page or section') }}</option>
                                    <option value="nofollow">{{ __('Do not pass on the link TIC and PR.') }}</option>
                                    <option value="noreferrer">{{ __('Do not pass HTTP headers over the link') }}</option>
                                    <option value="prefetch">{{ __('Indicates that you must cache the specified resource in advance') }}</option>
                                    <option value="prev">{{ __('Link to the previous page or section') }}</option>
                                    <option value="search">{{ __('Link to search') }}</option>
                                    <option value="sidebar">{{ __('Add link to browser favorites') }}</option>
                                    <option value="tag">{{ __('Indicates that the tag (tag) is relevant to the current document') }}</option>
                                    <option value="up">{{ __('Link to the parent page') }}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>{{ __('Class') }}</label>
                                <input type="text" class="form-control" data-target="components--menu.style"
                                       placeholder="red">
                            </div>
                            <div class="form-group">
                                <label>{{ __('Link target') }}</label>
                                <select class="form-control" data-target="components--menu.target">
                                    <option value="_self" selected>{{ __('In the current window') }}</option>
                                    <option value="_blank">{{ __('In a new window') }}</option>
                                </select>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" data-action="components--menu#remove"
                            class="btn btn-link" id="menu.remove">
                        {{ __('Remove') }}
                    </button>

                    <button type="button" data-action="components--menu#clear"
                            class="btn btn-link" id="menu.reset">
                        {{ __('Close') }}
                    </button>

                    <button type="button" data-action="components--menu#add"
                            class="btn btn-default" id="menu.create">
                        {{ __('Create') }}
                    </button>

                    <button type="button" data-action="components--menu#save"
                            class="btn btn-default" id="menu.save">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

@stop
