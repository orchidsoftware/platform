<div class="hbox hbox-auto-xs" @attributes($attributes)>
    @foreach($manyForms as $key => $column)
        <div class="hbox-col">
            <div class="vbox @if(!$loop->first) pl-md-2 @endif @if(!$loop->last) pr-md-2 @endif">
                @foreach($column as $item)
                    {!! $item ?? '' !!}
                @endforeach
            </div>
        </div>
    @endforeach
</div>
