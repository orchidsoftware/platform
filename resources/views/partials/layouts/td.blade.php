<td class="text-{{$align}} @if(!$width) text-truncate @endif" data-column="{{ $slug }}">
    <div style="width:{{ ctype_digit($width) ? $width . 'px' : $width }}">
        @isset($render)
            {!! $value !!}
        @else
            {{ $value }}
        @endisset
    </div>
</td>
