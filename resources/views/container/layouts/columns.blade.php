<div class="hbox hbox-auto-xs">
    @foreach($manyForms as $key => $column)
        <div class="hbox-col lter">
            <div class="vbox">
                @foreach($column as $item)
                    {!! $item or '' !!}
                @endforeach
            </div>
        </div>
    @endforeach
</div>