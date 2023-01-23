@if(!\Orchid\Platform\Dashboard::assetsAreCurrent())
    <div class="alert alert-warning rounded shadow-sm mb-3 p-4">
        <div class="d-flex align-items-center mb-2 text-black">
            <x-orchid-icon path="exclamation" width="1.5em" height="1.5em" class="me-2"/>
            <h4 class="mb-0 fw-light">{{ __("Complete the update.") }}</h4>
        </div>

        <p>{{ __("The published Orchid assets are not up-to-date with the installed version. To update, run:") }}</p>
        <code class="user-select-all">php artisan orchid:publish</code>
    </div>
@endif
