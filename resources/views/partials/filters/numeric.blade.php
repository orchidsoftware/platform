<div class="dropdown d-inline-block" data-controller="filter">
    <button class="btn btn-sm btn-link dropdown-toggle"
            type="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            data-bs-boundary="viewport"
            aria-expanded="false">
        <x-orchid-icon path="filter"/>
    </button>
    <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
        <div class="py-2 px-3">
            <div class="form-group mb-2 g-0">
                <input type="number" name="filter[{{$column}}]"
                       class="form-control form-control-sm"
                       form="filters"
                       value="{{get_filter_string($column)}}"
                       placeholder="{{ __('Filter') }}"
                       autofocus
                >
            </div>
            <div class="line line-dashed border-bottom my-3"></div>
            <button type="submit" form="filters" class="btn btn-default btn-sm w-100">{{__('Apply')}}</button>
        </div>
    </div>
</div>
