<div class="map-place-{{$name}}-{{$lang}}">
    <div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">
        @if(isset($title))
            <label for="field-{{$slug}}">{{$title}}</label>
        @endif
		@php
			if(isset($prefix)) 
				$inputname=$prefix.'['.$lang.']'.$name;
			else $inputname=$name.$lang;

			if(isset($value['name'])) 
				$valuename=$value['name']; 
			else $valuename=$value;
        @endphp
		
        <div class="input-group">
            <input class="form-control {{$class or ''}}" id="place-{{$slug}}-{{$lang}}"
                   name="{{$inputname}}[name]" value="{{$valuename or ''}}"
                   placeholder="{{$placeholder or ''}}">
            <input type="hidden" id="lat-{{$slug}}-{{$lang}}" name="{{$inputname}}[lat]"
                   value="{{$value['lat'] or ''}}">
            <input type="hidden" id="lng-{{$slug}}-{{$lang}}" name="{{$inputname}}[lng]"
                   value="{{$value['lng'] or ''}}">				   
            <span class="input-group-btn">
            <button class="btn btn-default" type="button" data-toggle="modal"
                    data-target="#map-place-{{$slug}}-{{$lang}}"><i
                        class="icon-location-pin"></i></button>
            </span>
        </div>
    </div>
    @if(isset($help))
        <p class="form-text text-muted">{{$help}}</p>
    @endif
</div>
<!-- Modal  -->
<div class="modal fade" id="map-place-{{$slug}}-{{$lang}}" tabindex="-1" role="dialog"
     aria-labelledby="map-place-{{$slug}}-{{$lang}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title">Google Maps</h4>
            </div>
            <div class="modal-body">
                <div id="map-place-{{$slug}}-{{$lang}}-canvas" class="google-maps-canvas"
                     style="width: 100%; height: 300px"></div>
            </div>
        </div>
    </div>
</div>
@include('dashboard::partials.fields.hr', ['show' => $hr ?? true])


@push('scripts')


<script>
document.documentElement.addEventListener("googleMapsLoad", function(e) {

    var input = document.getElementById("place-{{$slug}}-{{$lang}}");
    var autocomplete{{$slug}}{{$lang}} = new google.maps.places.Autocomplete(input);


    autocomplete{{$slug}}{{$lang}}.addListener('place_changed', function () {
        var cors = autocomplete{{$slug}}{{$lang}}.getPlace().geometry.location;
        $('#lat-{{$slug}}-{{$lang}}').val(cors.lat());
        $('#lng-{{$slug}}-{{$lang}}').val(cors.lng());
    });


    $('#map-place-{{$slug}}-{{$lang}}').on('show.bs.modal', function () {


        setTimeout(function () {
            var myLatLng = {
                lat: parseFloat($('#lat-{{$slug}}-{{$lang}}').val()),
                lng: parseFloat($('#lng-{{$slug}}-{{$lang}}').val())
            };

            var map = new google.maps.Map(document.getElementById('map-place-{{$slug}}-{{$lang}}-canvas'), {
                center: myLatLng,
                zoom: 12
            });

            new google.maps.Marker({
                map: map,
                position: myLatLng,
                title: $('#place-{{$slug}}-{{$lang}}').val()
            });

        }, 300);


    });
});

window.loadGoogleMaps = {
    "load" : function () {
        if (window.google === undefined || window.google.maps === undefined) {
            window.loadGoogleMaps.status = true;
            $.getScript("https://maps.googleapis.com/maps/api/js?libraries=places&key={{config('services.google.maps.key')}}", function () {
                document.documentElement.dispatchEvent(new Event("googleMapsLoad"));
            });

        }
    },
    "status": false
};

$(function () {
    if(!window.loadGoogleMaps.status) {
        window.loadGoogleMaps.load();
    }
});

</script>
@endpush
