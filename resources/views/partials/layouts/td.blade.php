<td class="text-{{$align}}" data-column="{{ $slug }}">
    @isset($render)
        {!! $value !!}
    @else
        {{ $value }}
    @endisset
</td>
