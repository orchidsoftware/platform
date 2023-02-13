<th @empty(!$width) width="{{$width}}" @endempty class="text-{{$align}}" data-column="{{ $slug }}">
    <div class="d-inline-flex align-items-center">

        @includeWhen($filter !== null, "platform::partials.layouts.filter", ['filter' => $filter])

        @if($sort)
            <a href="{{ $sortUrl }}"
               class="@if(!is_sort($column)) text-muted @endif">
                {{$title}}

                <x-orchid-popover :content="$popover"/>

                @if(is_sort($column))
                    @php $sortIcon = get_sort($column) === 'desc' ? 'bs.sort-down' : 'bs.sort-up' @endphp
                    <x-orchid-icon :path="$sortIcon"/>
                @endif
            </a>
        @else
            {{$title}}

            <x-orchid-popover :content="$popover"/>
        @endif
    </div>

    @if($filterString)
        <div data-controller="filter" class="mt-2">
            <a href="#"
               data-action="filter#clearFilter"
               data-filter="{{$column}}"
               class="badge bg-light border d-inline-flex align-items-center">
                <span>{{ $filterString }}</span>
                <x-orchid-icon path="bs.x-lg" class="ms-1"/>
            </a>
        </div>
    @endif
</th>


