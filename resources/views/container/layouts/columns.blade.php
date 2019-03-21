<div class="hbox hbox-auto-xs">
    @foreach($manyForms as $key => $column)
        <div class="hbox-col">
            <div class="vbox">
                @foreach($column as $item)
                    {!! $item ?? '' !!}
                @endforeach
            </div>
        </div>
    @endforeach
</div>