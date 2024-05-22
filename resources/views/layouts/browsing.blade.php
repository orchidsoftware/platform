<div class="mb-3" @include("platform::components.dataAttributes")>
    <iframe @foreach($attributes as $key => $value) {{ $key }}='{{$value}}' @endforeach></iframe>
</div>
