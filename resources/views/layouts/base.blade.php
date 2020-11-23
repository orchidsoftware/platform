@extends('platform::dashboard')

@section('title')
    {{ __($name) }}
@endsection

@section('description')
    {{ __($description) }}
@endsection

@section('controller')
    screen--base
@endsection

@section('navbar')
    @foreach($commandBar as $command)
        <li>
            {!! $command !!}
        </li>
    @endforeach
@endsection

@section('content')
    <form id="post-form"
          class="mb-md-4"
          method="post"
          enctype="multipart/form-data"
          data-controller="layouts--form"
          data-action="keypress->layouts--form#disableKey
                           layouts--form#submit"
          data-layouts--form-validation="{{ $formValidateMessage }}"
          novalidate
    >
        {!! $layouts !!}
        @csrf
        @include('platform::partials.confirm')
    </form>
    <div id="modals-container">
        @stack('modals-container')
    </div>
    <div data-controller="screen--filter">
        <form id="filters" autocomplete="off" data-action="screen--filter#submit"></form>
    </div>
@endsection
