<th @empty(!$width) width="{{$width}}" @endempty class="text-{{$align}}" data-column="{{ $slug }}">
    <div>
        @if($sort)
            <a href="{{ $sortUrl }}"
               class="@if(!is_sort($column)) text-muted @endif">
                {{$title}}

                <x-orchid-popover :content="$popover"/>

                @if(is_sort($column))
                    @php $sortIcon = 'sort-amount-'.get_sort($column) @endphp
                    <x-orchid-icon :path="$sortIcon"/>
                @endif
            </a>
        @else
            {{$title}}

            <x-orchid-popover :content="$popover"/>
        @endif


            @includeWhen($filter !== null, "platform::partials.layouts.filter", ['filter' => $filter])
    </div>

    @if($filterString)
        <div data-controller="filter" class="mt-2">
            <a href="#"
               data-action="filter#clearFilter"
               data-filter="{{$column}}"
               class="badge bg-light border d-inline-flex align-items-center">
                <span>{{ $filterString }}</span>
                <x-orchid-icon path="cross" class="ms-1"/>
            </a>
        </div>
    @endif
</th>
