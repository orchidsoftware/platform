<div class="row">

    <div class="col-12 col-md-8">
        <p class="mb-2">
            {{ __("A backup code will let you access your account if your phone is lost,
            stolen, or you otherwise can't generate codes via your authenticator app.
            We ask that you save this unique, one-time use backup code in a safe place:") }}
        </p>

        <p class="mb-3 mt-3">
            <kbd class="h4">{{ $code }}</kbd>
        </p>

        <p class="text-danger mb-2">
            <strong>
                {{ __('Without access to your authenticator app or backup code,
                you will permanently lose access to your account.') }}
            </strong>
        </p>

        <p class="mb-2">
            {{ __("To use the backup code, simply enter it during two-factor
          authentication where you'd normally enter a generated code.") }}
        </p>

        <p class="mb-2">
            {{ __('Please take a moment to put this code in a safe place.') }}
        </p>

        <p>
            <strong>{{ __('This code will not be shown again!') }}</strong>
        </p>

    </div>
</div>
