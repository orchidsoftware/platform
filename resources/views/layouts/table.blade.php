@empty(!$title)
    <fieldset>
            <div class="col p-0 px-3">
                <legend class="text-black">
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
        <table class="table
            @if($striped) table-striped @endif
            @if($bordered) table-bordered @endif
            @if($hoverable) table-hover @endif
        ">
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
                        {!! $column->buildTd($source) !!}
                    @endforeach
                </tr>
            @endforeach

            @if($total->isNotEmpty())
                <tr>
                    @foreach($total as $column)
                        {!! $column->buildTd($repository) !!}
                    @endforeach
                </tr>
            @endif

            </tbody>
        </table>
    </div>

    @if(($rows instanceof \Illuminate\Contracts\Pagination\Paginator || $rows instanceof \Illuminate\Contracts\Pagination\CursorPaginator || $rows instanceof \Illuminate\Support\Collection) && $rows->isEmpty())
        <div class="text-center py-5 w-100">
            <h3 class="fw-light">
                @isset($iconNotFound)
                    <x-orchid-icon :path="$iconNotFound" class="block m-b"/>
                @endisset


                {!!  $textNotFound !!}
            </h3>

            {!! $subNotFound !!}
        </div>
    @endif

    @includeWhen(!empty($rows),
        'platform::layouts.pagination',[
            'paginator' => $rows,
            'columns' => $columns,
            'onEachSide' => $onEachSide,
    ])
</div>


