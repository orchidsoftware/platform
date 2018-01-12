@foreach ($attributes as $name => $value)
    @if(is_bool($value))
        {{$name}}
    @else
        {{$name}}="{{$value}}"
    @endif
@endforeach
