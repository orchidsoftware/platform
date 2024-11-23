<a href="{{ $url }}" class="d-flex align-items-center gap-md-3">
    @empty(!$image)
    <span class="thumb-sm avatar d-none d-md-inline-block">
      <img src="{{ $image }}" class="bg-light">
    </span>
    @endempty
    <div class="text-balance">
        <p class="mb-0">{{ $title }}</p>
        <small class="text-muted">{{ $subTitle }}</small>
    </div>
</a>
