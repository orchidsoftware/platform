<div data-controller="browsing" class="mb-3">
    <iframe @foreach($attributes as $key => $value) {{ $key }}='{{$value}}' @endforeach></iframe>
</div>
