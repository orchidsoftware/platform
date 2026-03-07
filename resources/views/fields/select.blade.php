@php
    // Lazy (HTTP) mode only when both lazyChunk is set and relation params exist (fromModel).
    // fromQuery/fromEnum/options() do not set relationModel, so lazy() is ignored and options load eagerly.
    $isLazy = isset($lazyChunk) && $lazyChunk !== null && !empty($relationModel);
@endphp
<div data-controller="select"
     data-select-placeholder-value="{{ $attributes['placeholder'] ?? '' }}"
     data-select-allow-empty-value="{{ $allowEmpty }}"
     data-select-message-notfound-value="{{ __('No results found') }}"
     data-select-allow-add-value="{{ var_export($allowAdd, true) }}"
     data-select-message-add-value="{{ __('Add') }}"
     @if($isLazy)
         data-select-route-value="{{ route('orchid.relation') }}"
         data-select-model-value="{{ $relationModel }}"
         data-select-name-value="{{ $relationName }}"
         data-select-key-value="{{ $relationKey }}"
         data-select-scope-value="{{ $relationScope }}"
         data-select-append-value="{{ $relationAppend }}"
         data-select-search-columns-value="{{ $relationSearchColumns }}"
         data-select-chunk-value="{{ $lazyChunk }}"
     @endif
>
    <select id="{{ $id ?? \Illuminate\Support\Str::random(8) }}" {{ $attributes }} @if($isLazy) data-select-target="select" @endif>
        @if($isLazy)
            @foreach (($value ?? []) as $option)
                <option selected value="{{ $option['id'] }}">{{ $option['text'] }}</option>
            @endforeach
        @else
            @foreach ($options as $key => $option)
                <option value="{{ $key }}"
                    @isset($value)
                        @if (is_array($value) && in_array($key, $value)) selected
                        @elseif (isset($value[$key]) && $value[$key] == $option) selected
                        @elseif ($key == $value) selected
                        @endif
                    @endisset
                >{{ $option }}</option>
            @endforeach
        @endif
    </select>
</div>
