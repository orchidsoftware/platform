<div class="col-auto ml-auto p-0" data-turbolinks-permanent>
    <a href="{{ route('platform.notifications') }}"
       class="nav-link p-0 v-center"
       data-controller="layouts--notification"
       data-layouts--notification-count="{{ count($notifications) }}"
       data-layouts--notification-url="{{ route('platform.api.notifications') }}"
       data-layouts--notification-method="post"
       data-layouts--notification-interval="{{ config('platform.notifications.interval', 60) }}"
    >
        <x-orchid-icon path="bell"/>

        <template id="notification-circle">
            <x-orchid-icon path="circle" width="0.5em" height="0.5em" />
        </template>

        <span class="badge badge-sm up bg-danger text-white" data-target="layouts--notification.badge"></span>
    </a>
</div>
