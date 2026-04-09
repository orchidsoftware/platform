<div class="modal fade center-scale"
     tabindex="-1"
     data-controller="modal"
     role="dialog"
     id="notification-modal"
>
    <div class="modal-dialog modal-fullscreen-md-down modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-baseline gap-3 p-4">
                <h4 class="modal-title text-body-emphasis fw-light text-balance text-break" data-modal-target="title">
                    {{ __('Notification') }}
                </h4>
                <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-4 py-4">
                <div class="position-relative d-flex flex-column gap-4" id="orchid-notifications">
                    @foreach(range(0, 2) as $i)
                        <div class="p-2 d-flex gap-3 align-items-center placeholder-wave opacity-50">

                            <div class="thumb-sm rounded overflow-hidden">
                                <span class="placeholder d-block w-100 h-100 ratio ratio-1x1"></span>
                            </div>

                            <div class="d-flex flex-column flex-grow-1 gap-2">
                                <span class="placeholder col-8 rounded"></span>
                                <small class="placeholder col-5 rounded text-muted"></small>
                            </div>

                        </div>
                    @endforeach
                </div>
            </div>
            <div class="modal-footer">
                <div id="orchid-notifications-footer">
                </div>
            </div>
        </div>
    </div>
</div>
