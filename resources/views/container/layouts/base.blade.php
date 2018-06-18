@extends('platform::layouts.dashboard')
@section('title',trans($screen->name))
@section('description',trans($screen->description))
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
        <div class="not-found">
            <form id="post-form" method="post" enctype="multipart/form-data">
                {!! $screen->build() !!}
                @csrf
            </form>
        </div>
    </section>
    <div id="modals-container">
        @stack('modals-container')
    </div>
    <form id="filters"></form>
@stop