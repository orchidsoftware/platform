<div class="modal fade center-scale"
     tabindex="-1"
     data-controller="modal"
     role="dialog"
     id="search-modal"
>
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">

            <div class="modal-header align-items-baseline gap-3">
                <h4 class="modal-title text-body-emphasis fw-light text-balance text-break"
                    data-modal-target="title">
                    {{ __('Search') }}
                </h4>
                <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal"
                        aria-label="Close">
                </button>
            </div>

            <div class="modal-body p-4 py-4">
                <div data-controller="search-docs">
                    <div class="position-relative d-flex flex-column gap-3" data-controller="search">
                        <div class="input-icon">
                            <input
                                data-action="keyup->search#query blur->search#blur focus->search#focus"
                                data-search-target="query"
                                autocomplete="off"
                                autofocus
                                type="text"
                                value="@yield('search')"
                                class="form-control"
                                placeholder="{{ __('What to search...') }}"
                            >
                            <div class="input-icon-addon">
                                <x-orchid-icon path="bs.search"/>
                            </div>
                        </div>
                        <div id="search-result"
                             class="d-flex flex-column gap-2 list-group">
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
