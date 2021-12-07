@component($typeForm, get_defined_vars())
    <div data-controller="relation"
         data-relation-id="{{$id}}"
         data-relation-placeholder="{{$attributes['placeholder'] ?? ''}}"
         data-relation-value="{{  $value }}"
         data-relation-model="{{ $relationModel }}"
         data-relation-name="{{ $relationName }}"
         data-relation-key="{{ $relationKey }}"
         data-relation-scope="{{ $relationScope }}"
         data-relation-search-columns="{{ $relationSearchColumns }}"
         data-relation-append="{{ $relationAppend }}"
         data-relation-chunk="{{ $chunk }}"
         data-relation-route="{{ route('platform.systems.relation') }}"
    >
        <select id="{{$id}}" data-relation-target="select" {{ $attributes }}>
        </select>
    </div>
@endcomponent
