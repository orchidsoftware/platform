{{-- Deprecated use directive @attributes --}}
@foreach ($attributes as $name => $value)

    @if(is_bool($value) && $value === false)
        @continue
    @endif

    @if(is_bool($value))
        {{$name}}
    @elseif(is_array($value))
        @json($value)
    @else
        {{$name}}="{{$value}}"
    @endif
@endforeach
