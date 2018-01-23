<div class="hbox hbox-auto-xs ">

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
