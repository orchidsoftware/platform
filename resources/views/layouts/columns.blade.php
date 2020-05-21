<div class="hbox hbox-auto-xs">
    @foreach($manyForms as $key => $column)
        <div class="hbox-col">
            <div class="vbox py-3 @if(!$loop->first) pl-2 @endif @if(!$loop->last) pr-2 @endif">
                @foreach($column as $item)
                    {!! $item ?? '' !!}
                @endforeach
            </div>
        </div>
    @endforeach
</div>
