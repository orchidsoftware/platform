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

<p class="h2 n-m fw-light d-flex align-items-center">
   <x-orchid-icon path="orchid" width="1.2em" height="1.2em"/>

    <span class="ms-3 d-none d-sm-block">
        ORCHID
    <small class="v-top opacity">Platform</small>
    </span>
</p>
