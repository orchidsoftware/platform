@foreach($manyForms as $key => $column)
    @foreach(\Illuminate\Support\Arr::wrap($column) as $item)
        {!! $item ?? '' !!}
    @endforeach
@endforeach
