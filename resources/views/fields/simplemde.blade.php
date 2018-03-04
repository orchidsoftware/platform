@component('dashboard::partials.fields.group',get_defined_vars())
    <div class="simplemde-wrapper">
        <textarea id="{{$id}}" @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>
            {{$attributes['value']}}
        </textarea>
    </div>
@endcomponent

@push('scripts')
<script>
    document.addEventListener('turbolinks:load', function() {
        dashboard.fields.simplemde.init("{{$id}}","{{$placeholder or ''}}");
    });
</script>
@endpush





