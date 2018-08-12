@component('platform::partials.fields.group',get_defined_vars())
    <div data-controller="fields--tag">
        <select @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
            @foreach($value as $tag)
                <option value="{{$tag}}" selected="selected">{{$tag}}</option>
            @endforeach
        </select>
    </div>
@endcomponent
