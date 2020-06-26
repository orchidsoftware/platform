<div class="row"
     data-controller="layouts--table"
     data-layouts--table-slug="{{$slug}}"
>
    <div class="w-100 table-responsive @if ($striped) table-striped @endif">
        <table class="table">
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
            </tbody>
        </table>

        @if($rows instanceof \Illuminate\Contracts\Pagination\Paginator && $rows->isEmpty())
            <div class="text-center bg-white pt-5 pb-5 w-100">
                <h3 class="font-thin">
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

