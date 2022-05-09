<div class="modal fade"
     id="confirm-dialog"
     data-controller="confirm"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-black fw-light">
                    {{ __('Are you sure?') }}
                </h4>
                <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="p-4" data-confirm-target="message">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-bs-dismiss="modal">
                    {{__('Cancel')}}
                </button>

                <div data-confirm-target="button">

                </div>
            </div>
        </div>
    </div>
</div>

