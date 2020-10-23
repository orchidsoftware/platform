@component($typeForm, get_defined_vars())
    <div class="row" data-controller="fields--datetime"
         data-fields--datetime-allow-input="true"
         data-fields--datetime-range="#end_{{ \Illuminate\Support\Str::slug($attributes['name']) }}">
        <div class="col-md-6 pr-1">
            <div class="form-group">
                <input type="text"
                       @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
                       name="{{ $attributes['name'] }}[start]"
                       id='start_{{ $attributes['name'] }}'
                       data-target="fields--datetime.instance"
                       value="{{ $value['start'] ?? null }}"
                       class="form-control">
            </div>
        </div>

        <div class="col-md-6 pl-1">
            <div class="form-group">
                <input type="text"
                       @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
                       name="{{ $attributes['name'] }}[end]"
                       data-target="fields--datetime.instance"
                       id='end_{{ \Illuminate\Support\Str::slug($attributes['name']) }}'
                       value="{{ $value['end'] ?? null }}"
                       class="form-control">
            </div>
        </div>
    </div>
@endcomponent
