@component($typeForm,get_defined_vars())
    <div data-controller="fields--tinymce" data-theme="{{$theme ?? 'inlite'}}">
        <div class="tinymce b wrapper" id="tinymce-wrapper-{{$id}}" style="min-height: {{ $attributes['height'] }}">
            {!! $value !!}
        </div>
        <input type="hidden" @include('platform::partials.fields.attributes', ['attributes' => $attributes])>
    </div>
@endcomponent