<div class="row g-3">
    @foreach($manyForms as $key => $column)
        <div class="col-md">
            @foreach($column as $item)
                {!! $item ?? '' !!}
            @endforeach
        </div>
    @endforeach
</div>
