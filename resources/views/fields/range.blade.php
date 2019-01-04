@component($typeForm,get_defined_vars())
    <div class="row">
        <div class="col-md-6 pr-0">
            <div class="form-group">
                <input type="text"
                       form="{{ $attributes['form'] ?? null }}"
                       name="start_{{ $attributes['name'] }}"
                       id='start_{{ $attributes['name'] }}'
                       value="{{ $attributes['value']['start'] ?? null }}"
                       class="form-control"
                       data-controller="fields--datetime"
                       data-fields--datetime-allow-input="true"
                       data-fields--datetime-range="#end_{{ $attributes['name'] }}">
            </div>
        </div>

        <div class="col-md-6 pl-0">
            <div class="form-group">
                <input type="text"
                       form="{{ $attributes['form'] ?? null }}"
                       name="end_{{ $attributes['name'] }}"
                       id='end_{{ $attributes['name'] }}'
                       value="{{ $attributes['value']['end'] ?? null }}"
                       class="form-control">
            </div>
        </div>
    </div>
@endcomponent