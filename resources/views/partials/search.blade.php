@empty(!Dashboard::getSearch()->all())
    <div class="p-3">
        <div class="dropdown position-relative" data-controller="layouts--search">
            <div class="input-icon">
                <input
                    data-action="keyup->layouts--search#query blur->layouts--search#blur focus->layouts--search#focus"
                    data-target="layouts--search.query"
                    type="text"
                    value="@yield('search')"
                       class="form-control input-sm padder bg-dark text-white"
                       placeholder="{{ __('What to search...') }}"
                >
                <div class="input-icon-addon">
                    <x-orchid-icon path="magnifier"/>
                </div>
            </div>
            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow bg-white w-100"
                 x-placement="start-left" id="search-result">
            </div>
        </div>
    </div>
@endempty
