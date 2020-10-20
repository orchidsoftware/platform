<div class="dropdown d-inline-block">
    <button class="btn btn-sm btn-link dropdown-toggle"
            type="button"
            data-toggle="dropdown"
            aria-haspopup="true"
            data-boundary="viewport"
            aria-expanded="false">
        <x-orchid-icon path="filter"/>
    </button>
    <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow" x-placement="bottom-end">
        <div class="wrapper-sm">
            <div class="form-group mb-2 no-gutters">
                <input type="number" name="filter[{{$column}}]"
                       class="form-control form-control-sm"
                       form="filters"
                       value="{{get_filter_string($column)}}"
                       placeholder="{{ __('Filter') }}"
                >
            </div>
            <div class="line line-dashed border-bottom my-3"></div>
            <button type="submit" form="filters" class="btn btn-default btn-sm w-100">{{__('Apply')}}</button>
        </div>
    </div>
</div>
