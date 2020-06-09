<div class="py-3">
    <p>Two factor authentication (2FA) strengthens access security by requiring two methods (also referred to as
        factors) to verify your identity. Two factor authentication protects against phishing, social engineering and
        password brute force attacks and secures your logins from attackers exploiting weak or stolen credentials.</p>

    <p>To enable two-factor authentication, you'll need an app that supports TOTP such as Authy, Google Authenticator,
        or KeePassXC.</p>

    <strong>1. Scan this barcode with your authenticator app:</strong>

    <p>
        <img src="{{$image ?? '' }}" alt="QR Code" class="img-fluid">
    </p>

    <strong>2.Enter the pin the code to Enable 2FA</strong><br/><br/>

    {!!  \Orchid\Screen\Fields\Input::make('token')
        ->title('Authenticator Code')
        ->placeholder('Authenticator code')
        ->required()
    !!}

    {!! \Orchid\Screen\Fields\Input::make('secret')->type('hidden')->value($secret ?? '') !!}
</div>
