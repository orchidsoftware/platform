<div class="col-md-12" data-controller="filter">
    <div class="btn-group ps-4" role="group">
        <button class="btn btn-link dropdown-toggle ps-0 d-flex align-items-center text-decoration-none"
                data-bs-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
            <x-orchid-icon path="bs.funnel"/>
            <span class="ms-1">{{__('Filters')}}</span>
        </button>

        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow py-0"
             aria-labelledby="navbarDropdownMenuLink"
             data-turbo-permanent
             data-action="click->filter#onMenuClick"
        >
            @if($filters->where('display', true)->count() >= 2000)
                @foreach($filters->where('display', true) as $idx => $filter)
                    <a class="dropdown-item dropdown-toggle {{$loop->first || $loop->last ? 'py-2': ''}}" href="#" data-filter-index="{{$idx}}"
                       data-action="filter#onFilterClick">
                        {{ $filter->name() }}
                    </a>
                    <div class="dropdown-menu" data-action="click->filter#onMenuClick"
                         data-filter-target="filterItem">

                        <div class="p-3 w-md">
                            {!! $filter->render() !!}
                        </div>

                        <div class="bg-light p-3 w-md">
                            <button type="submit"
                                    form="filters"
                                    class="btn btn-link btn-sm w-100 border"
                                    data-action="click->filter#submit">
                                <span class="w-100 text-center">{{__('Apply')}}</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="dropdown-toggle" data-action="click->filter#onMenuClick"
                     data-filter-target="filterItem">
                    <div class="p-3 w-md">
                        @foreach($filters->where('display', true) as $idx => $filter)
                            {!! $filter->render() !!}
                        @endforeach
                    </div>

                    <div class="bg-light p-3 w-md">
                        <button type="submit"
                                form="filters"
                                class="btn btn-link btn-sm w-100 border"
                                data-action="click->filter#submit">
                            <span class="w-100 text-center">{{__('Apply')}}</span>
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
                <x-orchid-icon path="bs.x-lg" class="ms-1"/>
            </a>
        @endif
    @endforeach
</div>

