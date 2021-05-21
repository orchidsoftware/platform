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
        <div data-action="click->filter#onMenuClick">
            <div data-controller="datetime" class="input-group"
                data-datetime-inline="true"
                data-datetime-static="true"
              >
              <input class="d-none"
                     name="filter[{{$column}}]"
                     data-datetime-target="instance"
                     value="{{get_filter_string($column)}}"
                     form="filters"
                     placeholder="{{ __('Filter') }}"
                     autofocus
              >
            </div>
            <div class="py-2 px-3">
                <div class="line line-dashed border-bottom my-3"></div>
                <button type="submit" form="filters" class="btn btn-default btn-sm w-100">{{__('Apply')}}</button>
            </div>
        </div>
    </div>
</div>
