@foreach($manyForms as $key => $column)

    @php $column = \Illuminate\Support\Arr::wrap($column) @endphp

    @foreach($column as $item)
        {!! $item ?? '' !!}
    @endforeach
@endforeach
