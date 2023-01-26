<div class="ms-auto d-inline-flex align-items-center">
    <a href="{{ route('platform.notifications') }}"
       class="nav-link p-0 d-flex align-items-center"
       data-controller="notification"
       data-notification-count="{{ count($notifications) }}"
       data-notification-url="{{ route('platform.api.notifications') }}"
       data-notification-method="post"
       data-notification-interval="{{ config('platform.notifications.interval') }}"
       data-turbolinks-permanent
    >
        <x-orchid-icon path="bs.bell"/>

        <template id="notification-circle">
            <x-orchid-icon path="bs.circle-fill" width="0.5em" height="0.5em" />
        </template>

        <span class="badge up bg-danger text-white" data-notification-target="badge"></span>
    </a>
</div>
