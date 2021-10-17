@component($typeForm, get_defined_vars())
    <div class="row">
        <div class="col-md-6 pe-1">
            <div class="form-group">
                <input type="text"
                       name="{{ $attributes['name'] }}[start]"
                       id='start_{{ \Illuminate\Support\Str::slug($attributes['name']) }}'
                       value="{{ $value['start'] ?? null }}"
                       {{ $attributes }}
                       >
            </div>
        </div>

        <div class="col-md-6 ps-1">
            <div class="form-group">
                <input type="text"
                       name="{{ $attributes['name'] }}[end]"
                       id='end_{{ \Illuminate\Support\Str::slug($attributes['name']) }}'
                       value="{{ $value['end'] ?? null }}"
                       {{ $attributes }}
                       >
            </div>
        </div>
    </div>
@endcomponent
