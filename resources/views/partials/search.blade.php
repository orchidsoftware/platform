@if(Dashboard::getSearch()->isNotEmpty())
    <div class="p-3">
        <div class="position-relative overflow-hidden">
            <div class="input-icon">
                <input class="form-control bg-dark text-white"
                       type="text"
                       readonly
                       placeholder="{{ __('What to search...') }}">
                <div class="input-icon-addon">
                    <x-orchid-icon path="bs.search"/>
                </div>
            </div>
            <a href="#"
               data-bs-toggle="modal"
               data-bs-target="#search-modal"
               class="stretched-link"></a>
        </div>
    </div>
@else
    <div class="divider my-2"></div>
@endif
