<div class="toast-wrapper" data-controller="toast">
    <template id="toast">
        <div class="toast"
             role="alert"
             aria-live="assertive"
             aria-atomic="true"
             data-delay="5000"
             data-autohide="true">
            <div class="toast-body p-3 bg-white rounded shadow-sm d-flex">
                <p class="mb-0">
                    <span class="text-{type}">
                        <x-orchid-icon path="circle" class="me-2"/>
                    </span>
                    {message}
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </template>


    @if (session()->has(\Orchid\Alert\Toast::SESSION_MESSAGE))
        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-delay="{{ session(\Orchid\Alert\Toast::SESSION_DELAY) }}"
             data-autohide="{{ session(\Orchid\Alert\Toast::SESSION_AUTO_HIDE) }}">
            <div class="toast-body p-3 bg-white rounded shadow-sm d-flex">
                <p class="mb-0">
                    <span class="text-{{ session(\Orchid\Alert\Toast::SESSION_LEVEL) }}">
                        <x-orchid-icon path="circle" class="me-2"/>
                    </span>

                    {{ session(\Orchid\Alert\Toast::SESSION_MESSAGE) }}
                </p>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    @endif

</div>


