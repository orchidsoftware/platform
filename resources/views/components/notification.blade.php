<a href="{{ route('platform.notifications') }}"
   class="m-auto d-flex align-items-center btn btn-link position-relative px-1 py-0 h-100"
   data-controller="notification"
   data-notification-count="{{ count($notifications) }}"
   data-notification-url="{{ route('platform.api.notifications') }}"
   data-notification-method="post"
   data-notification-interval="{{ config('platform.notifications.interval') }}"
>
    <x-orchid-icon path="bs.bell" width="1.1em" height="1.1em" />

    <template id="notification-circle">
        <x-orchid-icon path="bs.circle-fill" width="0.4em" height="0.4em" />
    </template>

    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" data-notification-target="badge">
    </span>
</a>

