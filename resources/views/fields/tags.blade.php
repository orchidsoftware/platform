@component($typeForm, get_defined_vars())
    <div data-controller="fields--tag">
        <select @attributes($attributes)>
            @foreach($value as $tag)
                <option value="{{$tag['slug'] ?? $tag}}" selected="selected">{{$tag['name'] ?? $tag}}</option>
            @endforeach
        </select>
    </div>
@endcomponent
