@foreach($manyForms as $key => $column)
    @foreach($column as $item)
        {!! $item or '' !!}
    @endforeach
@endforeach