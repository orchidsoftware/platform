@extends('platform::auth')
@section('title',__('Sign in to your account'))

@section('content')
    <h1 class="h4 text-black mb-4">{{__('Sign in to your account')}}</h1>

    <form class="m-t-md"
          role="form"
          method="POST"
          data-controller="layouts--form"
          data-action="layouts--form#submit"
          data-layouts--form-button-animate="#button-login"
          data-layouts--form-button-text="{{ __('Loading...') }}"
          action="{{ route('platform.login.auth') }}">
        @csrf

        @includeWhen($isLockUser,'platform::auth.lockme')
        @includeWhen(!$isLockUser,'platform::auth.signin')
    </form>
@endsection
