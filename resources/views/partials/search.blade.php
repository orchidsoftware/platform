@empty(!Dashboard::getSearch()->all())
    <div class="p-3">
        <div class="dropdown position-relative" data-controller="search">
            <div class="input-icon">
                <input
                    data-action="keyup->search#query blur->search#blur focus->search#focus"
                    data-target="search.query"
                    type="text"
                    value="@yield('search')"
                       class="form-control input-sm padder bg-dark text-white"
                       placeholder="{{ __('What to search...') }}"
                >
                <div class="input-icon-addon">
                    <x-orchid-icon path="magnifier"/>
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow bg-white w-100"
                 x-placement="start-left" id="search-result">
            </div>
        </div>
    </div>
@endempty
