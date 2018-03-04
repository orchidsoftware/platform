@component('dashboard::partials.fields.group',get_defined_vars())
    <div class="tinymce-{{$id}} b wrapper" style="min-height: 300px">
    {!! $value !!}
    </div>
    <input type="hidden" @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>
@endcomponent

@push('scripts')
<script>
    document.addEventListener('turbolinks:load', function() {
        dashboard.fields.tinymce.init("{{$id}}","{{$theme or 'inlite'}}");
    });
</script>
@endpush
