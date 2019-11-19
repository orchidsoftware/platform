@push('head')
    <link
          href="{{ route('platform.resource', ['orchid', 'favicon/orchid-pinned-tab.svg']) }}"
          data-turbolinks-permanent
          data-controller="layouts--favicon"
          id="favicon"
          rel="icon"
    >
@endpush

<p class="h2 n-m font-thin v-center">
    <i class="icon-orchid"></i>
    <span class="m-l d-none d-sm-block">
        ORCHID
    <small style="
    vertical-align: top;
    opacity: .75;
    ">Platform</small>
    </span>
</p>
