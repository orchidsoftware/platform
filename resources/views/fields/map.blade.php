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
    <div data-controller="fields--map">
        <div id="osmap" class="b" style="width:100%; height:300px; margin-bottom:10px;">

        </div>
        <input class="form-control" type="text"
               name="{{$inputname}}[name]"
               value="{{$valuename ?? ''}}"
               data-target="fields--map.address"
               data-action="keyup->fields--map#search"/>
        <div id="marker__results"></div>
        <div class="row mt-3">
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