<div class="row g-2">
    <div class="col-md-6">
        <label class="form-label small" for="min_{{ \Illuminate\Support\Str::slug($attributes['name']) }}">{{ __($fromLabel ?? 'Minimum') }}</label>
        <input name="{{ $attributes['name'] }}[min]"
               id="min_{{ \Illuminate\Support\Str::slug($attributes['name']) }}"
               value="{{ $value['min'] ?? null }}"
               placeholder="{{ __('Minimum') }}"
               {{ $attributes->except(['name', 'id', 'value', 'placeholder']) }}>
    </div>
    <div class="col-md-6">
        <label class="form-label small" for="max_{{ \Illuminate\Support\Str::slug($attributes['name']) }}">{{ __($toLabel ?? 'Maximum') }}</label>
        <input name="{{ $attributes['name'] }}[max]"
               id="max_{{ \Illuminate\Support\Str::slug($attributes['name']) }}"
               value="{{ $value['max'] ?? null }}"
               placeholder="{{ __('Maximum') }}"
               {{ $attributes->except(['name', 'id', 'value', 'placeholder']) }}>
    </div>
</div>
