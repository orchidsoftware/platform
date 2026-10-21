<div class="row g-2" data-controller="datetime"
     data-datetime-allow-input="true"
     data-datetime-range="#end_{{ $attributes['id'] }}"
     {{ $dataAttributes }}>
    <div class="col-md-6">
        <label class="form-label small" for="start_{{ $attributes['id'] }}">{{ __($fromLabel ?? 'From') }}</label>
        <input type="text"
               @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
               name="{{ $attributes['name'] }}[start]"
               id='start_{{ $attributes['id'] }}'
               data-datetime-target="instance"
               value="{{ $value['start'] ?? null }}"
               class="form-control">
    </div>

    <div class="col-md-6">
        <label class="form-label small" for="end_{{ $attributes['id'] }}">{{ __($toLabel ?? 'To') }}</label>
        <input type="text"
               @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
               name="{{ $attributes['name'] }}[end]"
               data-datetime-target="instance"
               id='end_{{ $attributes['id'] }}'
               value="{{ $value['end'] ?? null }}"
               class="form-control">
    </div>
</div>
