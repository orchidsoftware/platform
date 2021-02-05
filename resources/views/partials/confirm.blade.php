<div class="modal fade"
     id="confirm-dialog"
     data-controller="confirm"
     tabindex="-1"
     aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button"
                        class="close"
                        title="{{__('Close')}}"
                        data-dismiss="modal"
                        aria-label="Close">
                    <x-orchid-icon path="cross"/>
                </button>

                <h4 class="modal-title text-black font-weight-light">
                    {{ __('Are you sure?') }}
                </h4>
            </div>
            <div class="modal-body">
                <div class="p-4" data-target="confirm.message">

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">
                    {{__('Cancel')}}
                </button>

                <div data-target="confirm.button">

                </div>
            </div>
        </div>
    </div>
</div>

