<div class="simplemde-wrapper" data-controller="simplemde"
     data-simplemde-text-value='{!! \Illuminate\Support\Js::encode($value) !!}'>
    <textarea {{ $attributes }}></textarea>
    <input class="d-none upload" type="file" data-action="simplemde#upload">
</div>
