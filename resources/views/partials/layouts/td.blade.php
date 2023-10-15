<td class="text-{{$align}} @if(!$width) text-truncate @endif {{ $class }}" @if($style) style="{{ $style }}" @endif
    data-column="{{ $slug }}" colspan="{{ $colspan }}"
    @empty(!$width)style="min-width:{{ is_numeric($width) ? $width . 'px' : $width }};"@endempty
>
    <div>
        @isset($render)
            {!! $value !!}
        @else
            {{ $value }}
        @endisset
    </div>
</td>
