<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">

    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif


	<div class="simplemde-wrapper">

	<input class="simplemde-{{$lang}}-{{$slug}}"
		name="{{$fieldName}}"
		id="{{$id}}"
		type="hidden"
		value="{{ $value or old($name) }}"
		>
	</div>

    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>

@push('scripts')
<script>
$(function () {
	new SimpleMDE({
		element: document.getElementById("{{$id}}"),
		toolbar: ["bold", "italic", "heading", "|", "quote", "code", "unordered-list", "ordered-list", 
		"|", "link","image", "table","|","preview","side-by-side","fullscreen","|", "horizontal-rule","guide"],
		placeholder: "{{$placeholder or ''}}",
        spellChecker: false
	});
});
</script>
@endpush
