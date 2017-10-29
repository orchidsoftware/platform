<div class="hbox hbox-auto-xs bg-light">

    @foreach($colums as $key => $colum)
        <div class="col lter b-l">
            <div class="vbox">
                @foreach($colum as $item)
                    {!! $item or '' !!}
                @endforeach
            </div>
        </div>
    @endforeach

</div>
