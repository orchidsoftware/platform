<div class="bg-white rounded shadow-sm mb-3"
     data-controller="layouts--table"
     data-layouts--table-slug="{{$slug}}"
>
    <div class="w-100 table-responsive">
        <table class="table @if($striped) table-striped @endif">
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

        @if($rows instanceof \Illuminate\Contracts\Pagination\Paginator && $rows->isEmpty())
            <div class="text-center bg-white pt-5 pb-5 w-100 shadow-sm rounded">
                <h3 class="font-weight-light">
                    @isset($iconNotFound)
                        <x-orchid-icon :path="$iconNotFound" class="block m-b"/>
                    @endisset


                    {!!  $textNotFound !!}
                </h3>

                {!! $subNotFound !!}
            </div>
        @endif

        @includeWhen($rows instanceof \Illuminate\Contracts\Pagination\Paginator && $rows->isNotEmpty(),
            'platform::layouts.pagination',[
                'paginator' => $rows,
                'columns' => $columns
            ]
          )
    </div>



</div>

