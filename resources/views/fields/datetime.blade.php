@component('dashboard::partials.fields.group',get_defined_vars())
    <div class='input-group'>
        <input @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])
               data-date-format="{{$format or "YYYY-MM-DD HH:mm:ss"}}"
        >

        <span class="input-group-addon input-group-btn">
            <span class="btn btn-default"><i class="icon-calendar" aria-hidden="true"></i></span>
        </span>

    </div>
@endcomponent