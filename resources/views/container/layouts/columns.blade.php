<div class="hbox hbox-auto-xs bg-light">

    @foreach($manyForms as $key => $column)
        <div class="col lter b-l">
            <div class="vbox">
                @foreach($column as $item)
                    {!! $item or '' !!}
                @endforeach
            </div>
        </div>
    @endforeach

</div>
