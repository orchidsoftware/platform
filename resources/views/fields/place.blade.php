@component($typeForm,get_defined_vars())
    @php
        if(isset($prefix))
            $inputname=$prefix.'['.$lang.']'.$name;
        else $inputname=$name.$lang;
        if(isset($value['lat']))
            $lat=$value['lat'];
        else $lat='-26.509904531413927';
        if(isset($value['lng']))
            $lng=$value['lng'];
        else $lng='134.03320312500003';
        if(isset($value['name']))
            $valuename=$value['name'];
        else $valuename='';
    @endphp
    <style>
        .osm-list {
            margin-top:20px;
            padding-left: 20px;
        }
    </style>
    <div data-controller="fields--place">
        <div id="osmap" class="b" style="width:100%; height:300px; margin-bottom:10px;">

        </div>
        <input class="form-control" type="text"
               name="{{$inputname}}[name]"
               value="{{$valuename ?? ''}}"
               data-target="fields--place.address"
               data-action="keyup->fields--place#search"/>
        <div id="marker__results"></div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-md">
                <label>Latitude</label>
                <input class="form-control" id="marker__latitude"
                       name="{{$inputname}}[lat]" value="{{$lat ?? ''}}"/>
            </div>
            <div class="col-md">
                <label>Longitude</label>
                <input class="form-control" id="marker__longitude"
                       name="{{$inputname}}[lng]" value="{{$lng ?? ''}}"/>
            </div>
        </div>
    </div>
@endcomponent