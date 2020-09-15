@if (session()->has(\Orchid\Alert\Alert::SESSION_MESSAGE))
    <div class="alert alert-{{ session(\Orchid\Alert\Alert::SESSION_LEVEL) }} rounded shadow-sm mb-3 p-3">
        <button type="button"
                class="close"
                data-dismiss="alert"
                aria-hidden="true">&times;
        </button>
        {!! session(\Orchid\Alert\Alert::SESSION_MESSAGE) !!}

        @yield('flash_notification.sub_message')
    </div>
@endif

@empty(!$errors->count())
    <div class="alert alert-danger rounded shadow-sm mb-3 p-3" role="alert">
        <strong>{{  __('Oh snap!') }}</strong>
        {{ __('Change a few things up and try submitting again.') }}
        <ul class="m-t-xs">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
