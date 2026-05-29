<div data-controller="select"
     data-select-placeholder-value="{{ $attributes['placeholder'] ?? '' }}"
     data-select-allow-empty-value="{{ $allowEmptyValue ?? 'false' }}"
     data-select-message-notfound-value="{{ __('No results found') }}"
     data-select-allow-create-value="{{ $allowCreateValue ?? 'false' }}"
     data-select-message-add-value="{{ __('Add') }}"
     @if($isLazy ?? false)
         data-select-route-value="{{ route('orchid.choices') }}"
         data-select-choices-value="{{ $choices }}"
         data-select-chunk-value="{{ $lazyChunk }}"
     @endif
>
    <select
        {{ $attributes
            ->merge(['id' => $id])
            ->merge(($isLazy ?? false) ? ['data-select-target' => 'select'] : [])
            }}
    >
        @if($isLazy ?? false)
            @foreach (($value ?? []) as $option)
                <option selected value="{{ $option['id'] }}">{{ $option['text'] }}</option>
            @endforeach
        @else
            @foreach ($options as $key => $option)
                <option value="{{ $key }}" @selected(in_array((string) $key, $selectedValues ?? [], true))>{{ $option }}</option>
            @endforeach
        @endif
    </select>
</div>
