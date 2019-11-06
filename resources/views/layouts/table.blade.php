<div class="row"
     data-controller="layouts--table"
     data-layouts--table-slug="{{$slug}}"
    >
    <div class="w-full table-responsive-lg @if ($striped) table-striped @endif">
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
            <div class="text-center bg-white pt-5 pb-5 w-full">
                <h3 class="font-thin">
                    <i class="{{ $iconNotFound }} block m-b"></i>
                    {!!  $textNotFound !!}
                </h3>

                {!! $subNotFound !!}
            </div>
        @endif

        @includeWhen($rows instanceof \Illuminate\Contracts\Pagination\Paginator && $rows->isNotEmpty(),
            'platform::layouts.pagination',
            ['paginator' => $rows]
          )
    </div>

    @foreach($columns as $key => $column)

        <div class="custom-control custom-checkbox">
            <input type="checkbox"
                   class="custom-control-input"
                   id="{{ $column->sluggable().'-'.$key }}"
                   data-action="layouts--table#toggleColumn"
                   data-column="{{ $column->sluggable() }}"
            >
            <label class="custom-control-label" for="{{ $column->sluggable().'-'.$key }}">
                {{ $column->namming() }}
            </label>
        </div>
    @endforeach

</div>

