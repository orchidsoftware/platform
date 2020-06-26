@push('head')
    <link
          href="{{ route('platform.resource', ['orchid', 'favicon/orchid-pinned-tab.svg']) }}"
          id="favicon"
          rel="icon"
    >
@endpush

<p class="h2 n-m font-thin v-center">
    <x-orchid-icon path="orchid"/>

    <span class="m-l d-none d-sm-block">
        ORCHID
    <small class="v-top opacity">Platform</small>
    </span>
</p>
