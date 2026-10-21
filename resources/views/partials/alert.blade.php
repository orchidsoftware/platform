@if (session()->has(\Orchid\Alert\Alert::SESSION_MESSAGE))
    @php
        $alertLevel = session(\Orchid\Alert\Alert::SESSION_LEVEL);
        $alertIsAssertive = in_array($alertLevel, ['danger', 'error', 'warning'], true);
    @endphp
    <div class="alert alert-{{ $alertLevel }} rounded shadow-sm mb-3 p-4 d-flex"
         role="{{ $alertIsAssertive ? 'alert' : 'status' }}"
         aria-live="{{ $alertIsAssertive ? 'assertive' : 'polite' }}"
         data-turbo-temporary>
        {!! session(\Orchid\Alert\Alert::SESSION_MESSAGE) !!}

        @yield('flash_notification.sub_message')
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"
                aria-label="{{ __('Close') }}"></button>
    </div>
@endif

@empty(!$errors->count())
    <div class="alert alert-danger rounded shadow-sm mb-3 p-4" role="alert">
        <strong>{{ __('Check your entries') }}</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
