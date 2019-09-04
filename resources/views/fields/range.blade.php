@component($typeForm,get_defined_vars())
    <div class="row">
        <div class="col-md-6 pr-0">
            <div class="form-group">
                <input type="text"
                       @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
                       name="{{ $attributes['name'] }}[start]"
                       id='start_{{ $attributes['name'] }}'
                       value="{{ $attributes['value']['start'] ?? null }}"
                       class="form-control"
                       data-controller="fields--datetime"
                       data-fields--datetime-allow-input="true"
                       data-fields--datetime-range="#end_{{ \Illuminate\Support\Str::slug($attributes['name']) }}">
            </div>
        </div>

        <div class="col-md-6 pl-0">
            <div class="form-group">
                <input type="text"
                       @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
                       name="{{ $attributes['name'] }}[end]"
                       id='end_{{ \Illuminate\Support\Str::slug($attributes['name']) }}'
                       value="{{ $attributes['value']['end'] ?? null }}"
                       class="form-control">
            </div>
        </div>
    </div>
@endcomponent
