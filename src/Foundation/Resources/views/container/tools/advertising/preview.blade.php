<div class="wrapper">
    <div id="preview-context" class="panel b box-shadow-lg text-center square-background" style="width: 100%; min-height: 75vh;">
    </div>
</div>

@push('stylesheet')
<style>
    .square-background {
        background-color: #eee;
        background-image: linear-gradient(45deg, #6A6A6A 25%, transparent 25%, transparent 75%, #6A6A6A 75%, #6a6a6a),
        linear-gradient(45deg, #6A6A6A 25%, transparent 25%, transparent 75%, #6A6A6A 75%, #6A6A6A);
        background-size:20px 20px;
        background-position:0 0, 10px 10px
    }

    .square-background .img {
        min-width: 100% !important;
        object-fit: cover !important;
    }
</style>
@endpush