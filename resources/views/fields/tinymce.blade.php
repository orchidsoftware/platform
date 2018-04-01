@component('dashboard::partials.fields.group',get_defined_vars())
    <div data-controller="tinymce" data-theme="{{$theme or 'inlite'}}">
        <div class="tinymce b wrapper" id="tinymce-wrapper-{{$id}}" style="min-height: 300px;max-height: 600px">
            {!! $value !!}
        </div>
        <input type="hidden" @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>
    </div>
@endcomponent