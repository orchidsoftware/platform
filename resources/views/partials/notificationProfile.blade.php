<div class="pull-right text-center pl-3"
     data-turbolinks-permanent
     data-controller="layouts--reload"
     data-layouts--reload-url="{{ route('platform.profile.notifications') }}"
     data-layouts--reload-method="post"
     data-layouts--reload-interval="60000"

>
    <a href="{{ route('platform.notifications') }}"
       class="nav-link icon no-padder"
       data-controller="layouts--notification"
       data-layouts--notification-count="{{ count($notifications) }}"
    >
        <i class="icon-bell"></i>

        <span class="badge badge-sm up bg-danger text-white" data-target="layouts--notification.badge"></span>

        {{--
        @if(count($notifications) > 0)
            <span class="badge badge-sm up bg-danger text-white">
                    @if(count($notifications) < 10)
                    {{ count($notifications) }}
                @else
                    <i class="icon-circle"></i>
                @endif
            </span>
        @endif
        --}}

    </a>
</div>
