@component($typeForm, get_defined_vars())
    <div data-controller="map"
         data-map-id="{{$id}}"
         data-map-zoom="{{$zoom}}"
    >
        <div id="{{$id}}" class="osmap-map border mb-2 w-100" style="min-height: {{ $attributes['height'] }}">

        </div>
        <div class="row mt-3">
            <div class="col-md">
                <label for="{{$name}}[lat]">{{ __('Latitude') }}</label>
                <input class="form-control"
                       id="marker__latitude"
                       data-map-target="lat"
                       @if($required ?? false) required @endif
                       name="{{$name}}[lat]"
                       value="{{ $value['lat'] ?? '' }}"/>
            </div>
            <div class="col-md">
                <label for="{{$name}}[lng]">{{ __('Longitude') }}</label>
                <input class="form-control"
                       id="marker__longitude"

                       data-map-target="lng"
                       @if($required ?? false) required @endif
                       name="{{$name}}[lng]"
                       value="{{ $value['lng'] ?? '' }}"/>
            </div>
            <div class="col-md">
                <label>{{ __('Object search') }}</label>
                <input class="form-control" type="text"
                       value="{{$valuename ?? ''}}"
                       data-map-target="search"
                       data-action="keyup->map#search"/>
            </div>
        </div>

        <div class="marker-results"></div>

    </div>
@endcomponent
