<div class="wrapper-md code-block-wrapper">
    <div id="code-editor" class="code-block"></div>
</div>

<input type="hidden" id="code-data" name="code" @if(isset($item)) value="{{$item->file_name}}" @endif>

@push('stylesheet')
<style>
    .code-block-wrapper {
        height: 50vh;
    }

    .code-block {
        width: 100%;
        height: 100%;
    }
</style>
@endpush