<div class="map-place-{{$name}}-{{$lang}}"
     data-controller="fields--place"
     data-fields--place-slug="{{$slug}}-{{$lang}}"
     data-fields--place-key="{{config('services.google.maps.key')}}"
>
    @component($typeForm,get_defined_vars())

        @php
            if(isset($prefix))
                $inputname=$prefix.'['.$lang.']'.$name;
            else $inputname=$name.$lang;

            if(isset($value['name']))
                $valuename=$value['name'];
            else $valuename=$value;
        @endphp

        <div class="input-group">
            <input class="form-control {{$class ?? ''}}" id="place-{{$slug}}-{{$lang}}"
                   name="{{$inputname}}[name]" value="{{$valuename ?? ''}}"
                   placeholder="{{$placeholder ?? ''}}">
            <input type="hidden" id="lat-{{$slug}}-{{$lang}}" name="{{$inputname}}[lat]"
                   value="{{$value['lat'] ?? ''}}">
            <input type="hidden" id="lng-{{$slug}}-{{$lang}}" name="{{$inputname}}[lng]"
                   value="{{$value['lng'] ?? ''}}">
            <span class="input-group-btn">
            <button class="btn btn-default" type="button" data-toggle="modal"
                    data-target="#map-place-{{$slug}}-{{$lang}}"><i
                        class="icon-location-pin"></i></button>
            </span>
        </div>

    @endcomponent

    <!-- Modal -->
    <div class="modal fade" id="map-place-{{$slug}}-{{$lang}}" tabindex="-1" role="dialog"
         aria-labelledby="map-place-{{$slug}}-{{$lang}}">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title">Google Maps</h4>
                </div>
                <div class="modal-body">
                    <div id="map-place-{{$slug}}-{{$lang}}-canvas" class="google-maps-canvas"
                         style="width: 100%; height: 600px"></div>
                </div>
            </div>
        </div>
    </div>
</div>
