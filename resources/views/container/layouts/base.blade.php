@extends('platform::layouts.dashboard')
@section('title',__($screen->name))
@section('description',__($screen->description))
@section('controller','screen--base')
@section('navbar')
    <ul class="nav justify-content-end v-center">
        @foreach($screen->commandBar() as $command)
            <li>
                {!! $command->build($arguments) !!}
            </li>
        @endforeach
    </ul>
@stop
@section('content')
    <section>
        <form id="post-form" method="post" enctype="multipart/form-data">
            {!! $screen->build() !!}
            @csrf
        </form>
    </section>
    <div id="modals-container">
        @stack('modals-container')
    </div>
    <div data-controller="screen--filter">
        <form id="filters" autocomplete="off" data-action="screen--filter#submit"></form>
    </div>
@stop