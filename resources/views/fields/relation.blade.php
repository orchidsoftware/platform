@component($typeForm, get_defined_vars())
    <div data-controller="relation"
         data-relation-id="{{$id}}"
         data-relation-placeholder="{{$attributes['placeholder'] ?? ''}}"
         data-relation-model="{{ $relationModel }}"
         data-relation-name="{{ $relationName }}"
         data-relation-key="{{ $relationKey }}"
         data-relation-scope="{{ $relationScope }}"
         data-relation-search-columns="{{ $relationSearchColumns }}"
         data-relation-append="{{ $relationAppend }}"
         data-relation-chunk="{{ $chunk }}"
         data-relation-allow-empty="{{ $allowEmpty }}"
         data-relation-route="{{ route('platform.systems.relation') }}"
         data-relation-message-notfound="{{ __('No results found') }}"
         data-relation-message-add="{{ __('Add') }}"
    >
        <select id="{{$id}}" data-relation-target="select" {{ $attributes }}>
            @foreach ($value as $option)
                <option selected value="{{ $option['id'] }}">{{ $option['text'] }}</option>
            @endforeach
        </select>
    </div>
@endcomponent
