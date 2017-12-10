<div class="form-group{{ $errors->has($name) ? ' has-error' : '' }}">

    @if(isset($title))
        <label for="field-{{$name}}">{{$title}}</label>
    @endif


	<div class="simplemde-wrapper">

	<input class="simplemde-{{$lang}}-{{$slug}}"
		@if(isset($prefix))
			name="{{$prefix}}[{{$lang}}]{{$name}}"
		@else
			name="{{$lang}}{{$name}}"
		@endif
		   id="simplemde-{{$lang}}-{{$slug}}"
		   type="hidden"
		   value="{{ $value or old($name) }}"
		>
	</div>

    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
<div class="line line-dashed b-b line-lg"></div>

<script>
$(function () {
	new SimpleMDE({
		element: document.getElementById("simplemde-{{$lang}}-{{$slug}}"),
		toolbar: ["bold", "italic", "heading", "|", "quote", "code", "unordered-list", "ordered-list", 
		"|", "link","image", "table","|","preview","side-by-side","fullscreen","|", "horizontal-rule","guide"],
		placeholder: "{{$placeholder or ''}}",
        spellChecker: false
	});
});
</script>
