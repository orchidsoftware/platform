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
               class="badge badge-pill bg-light">
                {{ $filterString }}
            </a>
        </div>
    @endif
</th>
