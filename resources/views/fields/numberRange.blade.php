@component($typeForm, get_defined_vars())
    <div class="row">
        <div class="col-md-6 pe-1">
            <div class="form-group">
                <input type="text"
                       name="{{ $attributes['name'] }}[min]"
                       id='min_{{ \Illuminate\Support\Str::slug($attributes['name']) }}'
                       value="{{ $value['min'] ?? null }}"
                       placeholder="{{ __('Minimum') }}"
                       {{ $attributes }}
                       >
            </div>
        </div>

        <div class="col-md-6 ps-1">
            <div class="form-group">
                <input type="text"
                       name="{{ $attributes['name'] }}[max]"
                       id='max_{{ \Illuminate\Support\Str::slug($attributes['name']) }}'
                       value="{{ $value['max'] ?? null }}"
                       placeholder="{{ __('Maximum') }}"
                       {{ $attributes }}
                       >
            </div>
        </div>
    </div>
@endcomponent
