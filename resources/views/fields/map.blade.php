@component($typeForm, get_defined_vars())
    <div data-controller="fields--map"
         data-fields--map-id="{{$id}}"
         data-fields--map-zoom="{{$zoom}}"
    >
        <div id="{{$id}}" class="osmap-map border mb-2 w-100" style="min-height: {{ $attributes['height'] }}">

        </div>
        <div class="row mt-3">
            <div class="col-md">
                <label for="{{$name}}[lat]">{{ __('Latitude') }}</label>
                <input class="form-control"
                       id="marker__latitude"
                       data-target="fields--map.lat"
                       @if($required ?? false) required @endif
                       name="{{$name}}[lat]"
                       value="{{ $value['lat'] ?? '' }}"/>
            </div>
            <div class="col-md">
                <label for="{{$name}}[lng]">{{ __('Longitude') }}</label>
                <input class="form-control"
                       id="marker__longitude"

                       data-target="fields--map.lng"
                       @if($required ?? false) required @endif
                       name="{{$name}}[lng]"
                       value="{{ $value['lng'] ?? '' }}"/>
            </div>
            <div class="col-md">
                <label>{{ __('Object search') }}</label>
                <input class="form-control" type="text"
                       value="{{$valuename ?? ''}}"
                       data-target="fields--map.search"
                       data-action="keyup->fields--map#search"/>
            </div>
        </div>

        <div class="marker-results"></div>

    </div>
@endcomponent
