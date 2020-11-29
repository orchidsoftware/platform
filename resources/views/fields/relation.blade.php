@component($typeForm, get_defined_vars())
    <div data-controller="fields--relation"
         data-fields--relation-id="{{$id}}"
         data-fields--relation-placeholder="{{$attributes['placeholder'] ?? ''}}"
         data-fields--relation-value="{{  $value }}"
         data-fields--relation-model="{{ $relationModel }}"
         data-fields--relation-name="{{ $relationName }}"
         data-fields--relation-key="{{ $relationKey }}"
         data-fields--relation-scope="{{ $relationScope }}"
         data-fields--relation-search-columns="{{ $relationSearchColumns }}"
         data-fields--relation-append="{{ $relationAppend }}"
         data-fields--relation-route="{{ route('platform.systems.relation') }}"
    >
        <select id="{{$id}}" data-target="fields--relation.select" {{ $attributes }}>
        </select>
    </div>
@endcomponent
