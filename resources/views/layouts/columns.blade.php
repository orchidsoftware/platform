<div class="row g-3" @include("platform::components.dataAttributes")>
    @foreach($manyForms as $key => $column)
        <div class="col-md">
            @foreach($column as $item)
                {!! $item ?? '' !!}
            @endforeach
        </div>
    @endforeach
</div>
