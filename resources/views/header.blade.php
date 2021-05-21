@push('head')
    <meta name="robots" content="noindex" />
    <link
          href="{{ route('platform.resource', ['orchid', 'favicon.svg']) }}"
          sizes="any"
          type="image/svg+xml"
          id="favicon"
          rel="icon"
    >
@endpush

<div class="h2 fw-light d-flex align-items-center">
   <x-orchid-icon path="orchid" width="1.2em" height="1.2em"/>

    <p class="ms-3 my-0 d-none d-sm-block">
        ORCHID
        <small class="align-top opacity">Platform</small>
    </p>
</div>
