@empty(!$title)
    <fieldset>
            <div class="col p-0 px-3">
                <legend class="text-body-emphasis mt-2 mx-2">
                    {{ $title }}
                </legend>
            </div>
    </fieldset>
@endempty

<div class="bg-white rounded shadow-sm mb-3 overflow-hidden"
     data-controller="table"
     data-table-slug="{{$slug}}"
>

    <div class="table-responsive">
        <table @class([
                    'table',
                    'mb-0'           => $rows->isEmpty(),
                    'table-compact'  => $compact,
                    'table-striped'  => $striped,
                    'table-bordered' => $bordered,
                    'table-hover'    => $hoverable,
               ])>

            @if($showHeader)
                <thead>
                    <tr>
                        @foreach($columns as $column)
                            {!! $column->buildTh() !!}
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody>

            @foreach($rows as $source)
                <tr>
                    @foreach($columns as $column)
                        {!! $column->buildTd($source, $loop->parent) !!}
                    @endforeach
                </tr>
            @endforeach

            @if($total->isNotEmpty() && $rows->isNotEmpty())
                <tr>
                    @foreach($total as $column)
                        {!! $column->buildTd($repository, $loop) !!}
                    @endforeach
                </tr>
            @endif

            </tbody>
        </table>
    </div>

    @if($rows->isEmpty())
        <x-orchid-empty-state
            class="table-empty-state w-100 py-md-5"
            :icon="$emptyStateIcon"
            :title="$emptyStateTitle"
            :description="$emptyStateDescription"
        >
            {{ $emptyStateAction }}
        </x-orchid-empty-state>
    @else

        @include('orchid::layouts.pagination',[
                'paginator' => $rows,
                'columns' => $columns,
                'onEachSide' => $onEachSide,
        ])

    @endif
</div>
