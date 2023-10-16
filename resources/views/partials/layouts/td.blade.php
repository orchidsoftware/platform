<td class="text-{{$align}} @if(!$width) text-truncate @endif {{ $class }}"
    data-column="{{ $slug }}" colspan="{{ $colspan }}"
        @style([
        "min-width:$width;" => $width,
        "$style" => $style,
        ])
>
    <div>
        @isset($render)
            {!! $value !!}
        @else
            {{ $value }}
        @endisset
    </div>
</td>
