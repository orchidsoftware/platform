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


        @includeWhen(!is_null($filter), "platform::partials.filters.{$filter}", get_defined_vars())
    </div>

    @if($filterString)
        <div data-controller="filter">
            <a href="#"
               data-action="filter#clearFilter"
               data-filter="{{$column}}"
               class="badge badge-pill bg-light">
                {{ $filterString }}
            </a>
        </div>
    @endif
</th>
