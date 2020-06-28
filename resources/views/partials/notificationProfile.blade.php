<div class="pull-right text-center pl-3" data-turbolinks-permanent>
    <a href="{{ route('platform.notifications') }}"
       class="nav-link icon no-padder"
       data-controller="layouts--notification"
       data-layouts--notification-count="{{ count($notifications) }}"
       data-layouts--notification-url="{{ route('platform.api.notifications') }}"
       data-layouts--notification-method="post"
       data-layouts--notification-interval="60000"
    >
        <x-orchid-icon path="bell"/>

        <template id="notification-circle">
            <x-orchid-icon path="circle" width="0.5em" height="0.5em" />
        </template>

        <span class="badge badge-sm up bg-danger text-white" data-target="layouts--notification.badge"></span>
    </a>
</div>
