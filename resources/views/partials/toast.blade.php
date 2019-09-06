<div class="toast-wrapper" data-controller="layouts--toast">
    <template id="toast">
        <div class="toast"
             role="alert"
             aria-live="assertive"
             aria-atomic="true"
             data-delay="5000"
             data-autohide="true">
            <div class="toast-header p-3 v-center b-b">
                <i class="icon-circle text-{type} mr-2"></i>
                <span class="text-black font-thin mr-auto">{title}</span>

                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="toast-body p-3 bg-light">
                <p class="mb-0">{message}</p>
            </div>
        </div>
    </template>
</div>


