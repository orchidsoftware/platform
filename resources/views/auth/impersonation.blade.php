@extends('orchid::auth')
@section('title', __('Limited Access') . ' — ' . __('You are now impersonating this user'))

@section('content')
    <h1 class="h4 text-body-emphasis text-balance mb-4">{{ __('Limited Access') }}</h1>

    <form role="form"
          method="POST"
          data-controller="form"
          data-form-need-prevents-form-abandonment-value="false"
          data-action="form#submit"
          action="{{ route('orchid.switch.logout') }}">
        @csrf

        <p class="text-body-secondary text-balance">
            {{ __('This user does not have access to this page. Switch back to your account to continue.') }}
        </p>

        <button type="submit" class="btn btn-dark btn-block">
            <x-orchid-icon path="bs.box-arrow-in-right"
                           width="1.25em"
                           height="1.25em"
                           class="small me-2"/>
            {{ __('Switch to My Account') }}
        </button>

    </form>
@endsection
