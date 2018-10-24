@foreach($manyForms as $key => $column)
    @if (count($compose))<div @foreach ($compose as $key => $value) {{$key}}="{{$value}}" @endforeach>@endif
        @foreach($column as $item)
            {!! $item ?? '' !!}
        @endforeach
    @if (count($compose))</div>@endif
@endforeach