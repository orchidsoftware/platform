<a href="{{ route('platform.notifications') }}"
   class="m-auto d-flex align-items-center btn btn-link position-relative px-1 py-0 h-100 link-body-emphasis"
   data-controller="notification"
   data-notification-count-value="{{ count($notifications) }}"
   data-notification-url-value="{{ route('platform.api.notifications') }}"
   data-notification-method-value="post"
   data-notification-interval-value="{{ config('platform.notifications.interval') }}"
>
    <x-orchid-icon path="bs.bell" />

    <template id="notification-circle">
        <x-orchid-icon path="bs.circle-fill" width="0.4em" height="0.4em" />
    </template>

    <span class="position-absolute top-0 start-100 translate-middle badge rounded-circle bg-danger lh-1 aspect-ratio-1x1 d-none"
          data-notification-target="badge"></span>
</a>

