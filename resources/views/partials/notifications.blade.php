@php
    $notifications = Auth::user()
                        ->unreadNotifications
                        ->where('type',\Orchid\Platform\Notifications\DashboardNotification::class);
@endphp

@if(count($notifications) > 0)
    <div class="hidden-folded padder m-t m-b-sm text-muted text-xs">{{trans('platform::common.notifications')}}
    </div>
@endif

@forelse ($notifications as $notification)

    <a href="{{$notification->data['action'] or '#'}}" class="dropdown-item d-flex">
            <i class="icon-circle {{ $notification->data['type'] }} pull-left m-t-sm text-xs"></i>
            <span class="clear m-l-md">
                @if($notification->read())
                    <span>{{$notification->data['title']  or ''}}</span>
                @else
                    {{$notification->data['title']   or ''}}
                @endif
                <small class="text-muted clear text-ellipsis">{{$notification->data['message']   or ''}}</small>
          </span>
    </a>

@empty


<div class="d-flex">
    <p class="text-center m-0 w-full text-muted font-thin">{{trans('platform::common.no_notifications')}}</p>
</div>


@endforelse

@if(count($notifications) > 0)
    <div class="dropdown-divider"></div>

    <form action="{{route('platform.notification.read')}}"
          method="post"
          id="clear-notications-form">
        <button type="submit" class="btn btn-sm btn-link inline dropdown-item text-center text-muted-dark">
            <i class="icon-trash"></i> Mark all as read
        </button>
        @csrf
    </form>
@endif
