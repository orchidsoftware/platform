@extends('platform::dashboard')

@section('title')
    {{ __($name) }}
@endsection

@section('description')
    {{ __($description) }}
@endsection

@section('controller')
    base
@endsection

@section('navbar')
    @foreach($commandBar as $command)
        <li class="{{ !$loop->first ? 'ms-2' : ''}}">
            {!! $command !!}
        </li>
    @endforeach
@endsection

@section('content')
    <div id="modals-container">
        @stack('modals-container')
    </div>

    <form id="post-form"
          class="mb-md-4"
          method="post"
          enctype="multipart/form-data"
          data-controller="form"
          data-action="keypress->form#disableKey
                           form#submit"
          data-form-validation="{{ $formValidateMessage }}"
          novalidate
    >
        {!! $layouts !!}
        @csrf
        @include('platform::partials.confirm')
    </form>

    <div data-controller="filter">
        <form id="filters" autocomplete="off" data-action="filter#submit"></form>
    </div>
@endsection
