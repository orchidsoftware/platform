@component($typeForm, get_defined_vars())
    <div class="row" data-controller="datetime"
         data-datetime-allow-input="true"
         data-datetime-range="#end_{{ \Illuminate\Support\Str::slug($attributes['name']) }}">
        <div class="col-md-6 pe-auto pe-md-1">
            <div class="form-group">
                <input type="text"
                       @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
                       name="{{ $attributes['name'] }}[min]"
                       id='min_{{ $attributes['name'] }}'
                       data-datetime-target="instance"
                       value="{{ $value['min'] ?? null }}"
                       class="form-control">
            </div>
        </div>

        <div class="col-md-6 ps-auto ps-md-1">
            <div class="form-group">
                <input type="text"
                       @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
                       name="{{ $attributes['name'] }}[max]"
                       data-datetime-target="instance"
                       id='max_{{ \Illuminate\Support\Str::slug($attributes['name']) }}'
                       value="{{ $value['max'] ?? null }}"
                       class="form-control">
            </div>
        </div>
    </div>
@endcomponent
