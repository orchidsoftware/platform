<div class="row g-3">
    @foreach($manyForms as $key => $column)
        <div @class([
            'col-md',
            $columnClass[0] .' order-md-first' => $loop->index % 2 == 0,
            $columnClass[1] . ' order-md-last' => $loop->index % 2 != 0,
            'order-first' => $reverseOnPhone && $loop->index % 2 != 0
        ])>
            @foreach($column as $item)
                {!! $item ?? '' !!}
            @endforeach
        </div>
    @endforeach
</div>
