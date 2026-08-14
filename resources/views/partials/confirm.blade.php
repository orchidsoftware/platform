<div class="modal modal-confirm fade"
     id="confirm-dialog"
     data-controller="confirm"
     role="dialog"
     aria-labelledby="confirm-dialog-title"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title text-body-emphasis fw-light" id="confirm-dialog-title">
                    {{ __('Are you sure?') }}
                </h4>
                <button type="button"
                        class="btn-close"
                        title="{{ __('Close') }}"
                        data-bs-dismiss="modal"
                        aria-label="{{ __('Close') }}">
                </button>
            </div>
            <div class="modal-body">
                <div class="p-4" data-confirm-target="message">

                </div>
            </div>
            <div class="modal-footer modal-actions-stacked">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    {{ __('Cancel') }}
                </button>

                <div data-confirm-target="button">

                </div>
            </div>
        </div>
    </div>
</div>
