@empty(!$title)
    <fieldset>
            <div class="col p-0 px-3">
                <legend class="text-black text-black mt-2 mx-2">
                    {{ $title }}
                </legend>
            </div>
    </fieldset>
@endempty

<div class="bg-white rounded shadow-sm mb-3"
     data-controller="table"
     data-table-slug="{{$slug}}"
>

    <div class="table-responsive">
        <table @class([
                    'table',
                    'table-compact'  => $compact,
                    'table-striped'  => $striped,
                    'table-bordered' => $bordered,
                    'table-hover'    => $hoverable,
               ])>
            <thead>
                <tr>
                    @foreach($columns as $column)
                        {!! $column->buildTh() !!}
                    @endforeach
                </tr>
            </thead>
            <tbody>

            @foreach($rows as $source)
                <tr>
                    @foreach($columns as $column)
                        {!! $column->buildTd($source, $loop->parent) !!}
                    @endforeach
                </tr>
            @endforeach

            @if($total->isNotEmpty())
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
        <div class="text-center py-5 w-100">
            <h3 class="fw-light">
                @isset($iconNotFound)
                    <x-orchid-icon :path="$iconNotFound" class="block m-b"/>
                @endisset

                {!!  $textNotFound !!}
            </h3>

            {!! $subNotFound !!}
        </div>
    @else

        @include('platform::layouts.pagination',[
                'paginator' => $rows,
                'columns' => $columns,
                'onEachSide' => $onEachSide,
        ])

    @endif
</div>


