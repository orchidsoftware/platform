@extends('orchid::auth')
@section('title', $isLockUser ? __('Welcome back') : __('Sign in to your account'))

@section('content')
    <h1 class="h4 text-body-emphasis text-balance mb-4">
        {{ $isLockUser ? __('Welcome back') : __('Sign in to your account') }}
    </h1>

    <form class="d-flex flex-column gap-3"
          role="form"
          method="POST"
          data-controller="form"
          data-form-need-prevents-form-abandonment-value="false"
          data-action="form#submit"
          action="{{ route('orchid.login.auth') }}">
        @csrf

        @includeWhen($isLockUser, 'orchid::auth.lockme')
        @includeWhen(!$isLockUser, 'orchid::auth.signin')
    </form>
@endsection
