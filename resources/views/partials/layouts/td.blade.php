<td class="text-{{$align}} @if(!$width) text-truncate @endif {{ $class }}"
    data-column="{{ $slug }}" colspan="{{ $colspan }}"
    style="@empty(!$width)min-width:{{ is_numeric($width) ? $width . 'px' : $width }};@endempty {{ $style }}"
>
    <div>
        @isset($render)
            {!! $value !!}
        @else
            {{ $value }}
        @endisset
    </div>
</td>
