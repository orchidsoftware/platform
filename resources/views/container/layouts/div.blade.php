@foreach($manyForms as $key => $column)
    <div @foreach ($compose as $key => $value) {{$key}}="{{$value}}" @endforeach>
        @foreach($column as $item)
            {!! $item or '' !!}
        @endforeach
    </div>
@endforeach
