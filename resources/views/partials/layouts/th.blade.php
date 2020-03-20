<th width="{{$width}}" class="text-{{$align}}" data-column="{{ $slug }}">
    <div class="text-truncate">
        @if($sort)
            <a href="{{ $sortUrl }}"
               class="@if(!is_sort($column)) text-muted @endif">
                {{$title}}

                @if(is_sort($column))
                    <i class="icon-sort-amount-{{get_sort($column)}}"></i>
                @endif
            </a>
        @else
            {{$title}}
        @endif

        @includeWhen(!is_null($filter), "platform::partials.filters.{$filter}", get_defined_vars())
    </div>

    @if($filterString)
        <div data-controller="screen--filter">
            <a href="#"
               data-action="screen--filter#clearFilter"
               data-filter="{{$column}}"
               class="badge badge-pill badge-light">
                {{ $filterString }}
            </a>
        </div>
    @endif
</th>
