<option value="">{{ __("Don't Use") }}</option>
@empty(!$name)
    @foreach($models[$name]->get('columns',[]) as $column)
        <option
                value="{{$column['name']}}"
                @if(isset($related) && !empty($related))
                    @if($relation['related'] == $column['name'])
                    selected
                    @endif
                @endif
        >
            {{$column['name']}}
        </option>
    @endforeach
@endempty