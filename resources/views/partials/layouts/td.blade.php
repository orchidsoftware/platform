<td class="text-{{$align}} @if(!$width) text-truncate @endif" data-column="{{ $slug }}" colspan="{{ $colspan }}">
    <div @empty(!$width)style="width:{{ is_numeric($width) ? $width . 'px' : $width }}"@endempty>
        @isset($render)
            {!! $value !!}
        @else
            {{ $value }}
        @endisset
    </div>
</td>
