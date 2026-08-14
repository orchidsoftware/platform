@if(Orchid::getSearch()->isNotEmpty())
    <div class="p-3" data-controller="search">
        <div class="position-relative">
            <div class="input-icon">
                <button type="button"
                        data-bs-toggle="modal"
                        data-bs-target="#search-modal"
                        aria-label="{{ __('Search') }}"
                        class="form-control bg-dark text-white text-start">
                    <span class="opacity-50">{{ __('What to search...') }}</span>
                </button>
                <div class="input-icon-addon">
                    <x-orchid-icon path="bs.search"/>
                </div>
            </div>
        </div>
    </div>
@else
    <div class="divider my-2"></div>
@endif
