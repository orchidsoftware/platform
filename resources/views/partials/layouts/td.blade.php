<td class="text-{{$align}}">
    @isset($render)
        {!! $value !!}
    @else
        {{ $value }}
    @endisset
</td>
