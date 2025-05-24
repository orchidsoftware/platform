<div class="row" data-controller="datetime"
     data-datetime-allow-input="true"
     data-datetime-range="#end_{{ $attributes['id'] }}"
     {{ $dataAttributes }}>
    <div class="col-md-6 pe-auto pe-md-1">
        <div class="form-group">
            <input type="text"
                   @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
                   name="{{ $attributes['name'] }}[start]"
                   id='start_{{ $attributes['id'] }}'
                   data-datetime-target="instance"
                   value="{{ $value['start'] ?? null }}"
                   class="form-control">
        </div>
    </div>

    <div class="col-md-6 ps-auto ps-md-1">
        <div class="form-group">
            <input type="text"
                   @isset($attributes['form']) form="{{ $attributes['form'] ?? null }}" @endisset
                   name="{{ $attributes['name'] }}[end]"
                   data-datetime-target="instance"
                   id='end_{{ $attributes['id'] }}'
                   value="{{ $value['end'] ?? null }}"
                   class="form-control">
        </div>
    </div>
</div>
