@extends('platform::dashboard')

@section('title', (string) __($name))
@section('description', (string) __($description))
@section('controller', $controller)

@section('navbar')
    @foreach($commandBar as $command)
        <li>
            {!! $command !!}
        </li>
    @endforeach
@endsection

@section('content')
    <div id="modals-container">
        @stack('modals-container')
    </div>

    <x-orchid-stream target="post-form" :rule="\request()->routeIs('platform.watch')">

        <form id="post-form"
              class="mb-md-4 h-100"
              method="post"
              enctype="multipart/form-data"
              data-controller="form test"
              data-test-watched-value="{{ $watched }}"
              data-test-url-value="{{ route('platform.watch') }}"
              data-form-need-prevents-form-abandonment-value="{{ var_export($needPreventsAbandonment) }}"
              data-form-failed-validation-message-value="{{ $formValidateMessage }}"
              data-action="keypress->form#disableKey
                      turbo:before-fetch-request@document->form#confirmCancel
                      beforeunload@window->form#confirmCancel
                      change->form#changed
                      form#submit"
              novalidate
        >
            {!! $layouts !!}
            @csrf
            @include('platform::partials.confirm')
        </form>

    </x-orchid-stream>

    <div data-controller="filter">
        <form id="filters" autocomplete="off"
              data-action="filter#submit"
              data-form-need-prevents-form-abandonment-value="false"
        ></form>
    </div>

    @includeWhen(isset($state), 'platform::partials.state')
@endsection
