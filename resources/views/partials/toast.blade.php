<div class="toast-wrapper" data-controller="layouts--toast">
    <template id="toast">
        <div class="toast show"
             role="alert"
             aria-live="assertive"
             aria-atomic="true"
             data-delay="5000"
             data-autohide="true">
            <div class="toast-body p-3 bg-light">
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <p class="mb-0"> <i class="icon-circle text-{type} mr-2"></i> {message}</p>
            </div>
        </div>
    </template>


    @if (session()->has(\Orchid\Alert\Toast::SESSION_MESSAGE))
        <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-delay="{{ session(\Orchid\Alert\Toast::SESSION_DELAY) }}"
             data-autohide="{{ session(\Orchid\Alert\Toast::SESSION_AUTO_HIDE) }}">
            <div class="toast-body p-3 bg-light">
                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
                <p class="mb-0">
                    <i class="icon-circle text-{{ session(\Orchid\Alert\Toast::SESSION_LEVEL) }} mr-2"></i>
                    {{ session(\Orchid\Alert\Toast::SESSION_MESSAGE) }}
                </p>
            </div>
        </div>
    @endif

</div>


