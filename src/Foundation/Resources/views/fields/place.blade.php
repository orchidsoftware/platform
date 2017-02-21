<div class="map-place-{{$name}}-{{$lang}}">

    <div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

        @if(isset($title))
            <label for="field-{{$name}}">{{$title}}</label>
        @endif

        <div class="input-group">
            <input class="form-control {{$class or ''}}" id="place-{{str_slug($name)}}-{{$lang}}"
                   name="{{$prefix}}[{{$lang}}]{{$name}}[name]" value="{{$value['name'] or ''}}"
                   placeholder="Адрес ...">
            <input type="hidden" id="lat-{{str_slug($name)}}-{{$lang}}" name="{{$prefix}}[{{$lang}}]{{$name}}[lat]"
                   value="{{$value['lat'] or ''}}">
            <input type="hidden" id="lng-{{str_slug($name)}}-{{$lang}}" name="{{$prefix}}[{{$lang}}]{{$name}}[lng]"
                   value="{{$value['lng'] or ''}}">
            <span class="input-group-btn">
        <button class="btn btn-default" type="button" data-toggle="modal"
                data-target="#map-place-{{str_slug($name)}}-{{$lang}}"><i
                    class="fa fa-map-marker"></i></button>
    </span>
        </div>
    </div>


        @if(isset($help))
            <p class="help-block">{{$help}}</p>
        @endif
</div>



<!-- Modal -->
<div class="modal fade" id="map-place-{{str_slug($name)}}-{{$lang}}" tabindex="-1" role="dialog"
     aria-labelledby="map-place-{{str_slug($name)}}-{{$lang}}">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Google Maps</h4>
            </div>
            <div class="modal-body">
                <div id="map-place-{{str_slug($name)}}-{{$lang}}-canvas" class="google-maps-canvas"
                     style="width: 100%; height: 300px"></div>
            </div>
        </div>
    </div>
</div>




<div class="line line-dashed b-b line-lg"></div>


@push('scripts')


<script>

    document.addEventListener("DOMContentLoaded", function () {
        var input = document.getElementById("place-{{str_slug($name)}}-{{$lang}}");
        var autocomplete{{str_slug($name)}}{{$lang}} = new google.maps.places.Autocomplete(input);


        autocomplete{{str_slug($name)}}{{$lang}}.addListener('place_changed', function () {
            var cors = autocomplete{{str_slug($name)}}{{$lang}}.getPlace().geometry.location;
            $('#lat-{{str_slug($name)}}-{{$lang}}').val(cors.lat());
            $('#lng-{{str_slug($name)}}-{{$lang}}').val(cors.lng());
        });


        $('#map-place-{{str_slug($name)}}-{{$lang}}').on('show.bs.modal', function () {


            setTimeout(function () {
                var myLatLng = {
                    lat: parseFloat($('#lat-{{str_slug($name)}}-{{$lang}}').val()),
                    lng: parseFloat($('#lng-{{str_slug($name)}}-{{$lang}}').val())
                };

                var map = new google.maps.Map(document.getElementById('map-place-{{str_slug($name)}}-{{$lang}}-canvas'), {
                    center: myLatLng,
                    zoom: 12
                });

                 new google.maps.Marker({
                    map: map,
                    position: myLatLng,
                    title: $('#place-{{str_slug($name)}}-{{$lang}}').val()
                });

            }, 300);


        });

    });




</script>


@endpush