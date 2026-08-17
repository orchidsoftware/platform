<th @empty(!$width) width="{{$width}}" @endempty class="text-{{$align}}" data-column="{{ $slug }}">
    <div class="d-inline-flex align-items-center align-middle flex-nowrap gap-1 text-nowrap">
        @includeWhen($filter !== null, "orchid::partials.layouts.filter", ['filter' => $filter])

        @if($sort)
            <a href="{{ $sortUrl }}"
               class="d-inline-flex align-items-center gap-1 @if(!is_sort($column)) text-muted @endif">
                {!! $title !!}

                <x-orchid-popover :content="$popover"/>

                <span class="table-sort-indicator d-inline-flex align-items-center justify-content-center" aria-hidden="true">
                    @if(is_sort($column))
                        @php $sortIcon = get_sort($column) === 'desc' ? 'bs.sort-down' : 'bs.sort-up' @endphp
                        <x-orchid-icon :path="$sortIcon"/>
                    @endif
                </span>
            </a>
        @else
            {!! $title !!}

            <x-orchid-popover :content="$popover"/>
        @endif
    </div>

    @if($filterString)
        <div data-controller="filter" class="mt-2">
            <a href="#"
               data-action="filter#clearFilter"
               data-filter="{{$column}}"
               class="badge bg-light border d-inline-flex align-items-center link-body-emphasis gap-1">
                <span>{{ $filterString }}</span>
                <x-orchid-icon path="bs.x-lg"/>
            </a>
        </div>
    @endif
</th>
