<div class="modal fade center-scale"
     tabindex="-1"
     data-controller="modal"
     role="dialog"
     id="search-modal"
>
    <div class="modal-dialog modal-fullscreen-md-down" role="document">
        <div class="modal-content">

            <div class="modal-body p-4 py-4">
                <div class="position-relative d-flex flex-column gap-3"
                     data-controller="search"
                >
                    <div class="input-icon">
                        <div class="input-icon-addon">
                            <x-orchid-icon path="bs.search"/>
                        </div>
                        <input
                            data-action="input->search#query keydown->search#keydown"
                            data-search-target="query"
                            autocomplete="off"
                            autofocus
                            type="text"
                            value="@yield('search')"
                            class="form-control"
                            placeholder="{{ __('What to search...') }}"
                        >
                        <div class="input-icon-addon">
                            <button type="button" class="btn-close" title="Close" data-bs-dismiss="modal"
                                    aria-label="Close">
                            </button>
                        </div>
                    </div>
                    <div id="search-result"
                         data-search-target="result"
                         class="d-flex flex-column gap-2 list-group d-none">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
