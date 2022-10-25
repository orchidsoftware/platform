<div class="col-md-12" data-controller="filter">
    <div class="btn-group ps-4" role="group">
        <button class="btn btn-link dropdown-toggle ps-0 d-flex align-items-center"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
            <x-orchid-icon path="filter"/>
            <span class="ms-1">{{__('Filters')}}</span>
        </button>

        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow"
             aria-labelledby="navbarDropdownMenuLink"
             data-turbo-permanent
             data-action="click->filter#onMenuClick"
        >
            @if($filters->where('display', true)->count() >= 2)
                @foreach($filters->where('display', true) as $idx => $filter)
                    <a class="dropdown-item dropdown-toggle" href="#" data-filter-index="{{$idx}}"
                       data-action="filter#onFilterClick">
                        {{ $filter->name() }}
                    </a>
                    <div class="dropdown-menu" data-action="click->filter#onMenuClick"
                         data-filter-target="filterItem">
                        <div class="px-3 py-2 w-md">
                            {!! $filter->render() !!}
                            <div class="dropdown-divider"></div>
                            <button type="submit"
                                    form="filters"
                                    class="btn btn-sm btn-default">
                                {{ __('Apply') }}
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="dropdown-toggle" data-action="click->filter#onMenuClick"
                     data-filter-target="filterItem">
                    <div class="px-3 py-2 w-md">
                        {!! $filters->where('display', true)->first()->render() !!}
                        <div class="dropdown-divider"></div>
                        <button type="submit"
                                form="filters"
                                class="btn btn-sm btn-default"
                                data-action="click->filter#submit">
                            {{ __('Apply') }}
                        </button>
                    </div>
                </div>
            @endif


        </div>
    </div>
    @foreach($filters as $filter)
        @if($filter->display && $filter->isApply())
            <a href="{{ $filter->resetLink() }}" class="badge bg-light border me-1 p-1 d-inline-flex align-items-center">
                <span>{{$filter->value()}}</span>
                <x-orchid-icon path="cross" class="ms-1"/>
            </a>
        @endif
    @endforeach
</div>

