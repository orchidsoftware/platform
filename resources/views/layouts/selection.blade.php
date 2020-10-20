<div class="col-md-12" data-controller="screen--filter">
    <div class="btn-group" role="group">
        <button class="btn btn-link dropdown-toggle pl-0"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false">
            <x-orchid-icon path="filter"/>
            {{__('Filters')}}
        </button>

        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow"
             aria-labelledby="navbarDropdownMenuLink"
             data-turbolinks-permanent
             data-action="click->screen--filter#onMenuClick"
        >
            @if($filters->where('display', true)->count() >= 2)
                @foreach($filters->where('display', true) as $idx => $filter)
                    <a class="dropdown-item dropdown-toggle" href="#" data-filter-index="{{$idx}}"
                       data-action="screen--filter#onFilterClick">
                        {{ $filter->name() }}
                    </a>
                    <div class="dropdown-menu" data-action="click->screen--filter#onMenuClick"
                         data-target="screen--filter.filterItem">
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
                <div class="dropdown-toggle" data-action="click->screen--filter#onMenuClick"
                     data-target="screen--filter.filterItem">
                    <div class="px-3 py-2 w-md">
                        {!! $filters->where('display', true)->first()->render() !!}
                        <div class="dropdown-divider"></div>
                        <button type="submit"
                                form="filters"
                                class="btn btn-sm btn-default">
                            {{ __('Apply') }}
                        </button>
                    </div>
                </div>
            @endif


        </div>
    </div>
    @foreach($filters as $filter)
        @if($filter->display && $filter->isApply())
            <a href="{{ $filter->resetLink() }}" class="badge badge-light mr-1 p-1">
                {{$filter->value()}}
            </a>
        @endif
    @endforeach
</div>
