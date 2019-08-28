@extends('platform::dashboard')
@section('title',__($screen->name))
@section('description',__($screen->description))
@section('controller','screen--base')
@section('navbar')
    <ul class="nav command-bar justify-content-sm-end justify-content-start v-center">
        @foreach($screen->buildCommandBar() as $command)
            <li>
                {!! $command !!}
            </li>
        @endforeach
    </ul>
@stop
@section('content')
        <form id="post-form"
              class="wrapper"
              method="post"
              enctype="multipart/form-data"
              data-controller="layouts--form"
              data-action="layouts--form#submit"
              data-layouts--form-validation="{{ $screen->formValidateMessage() }}"
              novalidate
        >
            {!! $screen->build() !!}
            @csrf
        </form>
    <div id="modals-container">
        @stack('modals-container')
    </div>
    <div data-controller="screen--filter">
        <form id="filters" autocomplete="off" data-action="screen--filter#submit"></form>
    </div>
@stop
