<div class="row">
    @foreach($manyForms as $key => $column)
        <div class="col-auto col-xs-12">
            @foreach($column as $item)
                {!! $item ?? '' !!}
            @endforeach
        </div>
    @endforeach
</div>
