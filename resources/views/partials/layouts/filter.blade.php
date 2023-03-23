<div class="dropdown d-inline-block" data-controller="filter" data-action="click->filter#onMenuClick">
    <button class="btn btn-sm btn-link dropdown-toggle p-0 me-1"
            type="button"
            data-bs-toggle="dropdown"
            aria-haspopup="true"
            data-bs-boundary="viewport"
            aria-expanded="false">
        <x-orchid-icon path="bs.funnel"/>
    </button>
    <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow py-0" x-placement="bottom-end">
        <div class="p-3">
            {!! $filter !!}
        </div>

        <div class="bg-light p-3">
            <button type="submit" form="filters" class="btn btn-link btn-sm w-100 border">
                <span class="w-100 text-center">{{__('Apply')}}</span>
            </button>
        </div>
    </div>
</div>
