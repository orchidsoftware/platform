@push('head')
    <link
          href="{{ route('platform.resource', ['orchid', 'favicon.svg']) }}"
          sizes="any"
          type="image/svg+xml"
          id="favicon"
          rel="icon"
    >
@endpush

<p class="h2 n-m font-weight-light v-center">
   <x-orchid-icon path="orchid"/>

    <span class="ml-3 d-none d-sm-block">
        ORCHID
    <small class="v-top opacity">Platform</small>
    </span>
</p>
