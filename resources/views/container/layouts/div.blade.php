@foreach($manyForms as $key => $column)
    <div @foreach ($compose as $key => $value) {{$key}}="{{$value}}" @endforeach data-async>
    @foreach($column as $item)
    {!! $item or '' !!}
    @endforeach
    </div>
@endforeach
