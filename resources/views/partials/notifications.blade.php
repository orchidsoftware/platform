@php
    $notifications = Auth::user()
                        ->unreadNotifications
                        ->where('type',\Orchid\Platform\Notifications\DashboardNotification::class);
@endphp

@if(count($notifications) > 0)
    <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">{{trans('platform::common.notifications')}}
        <form action="{{route('platform.notification.read')}}"
              method="post"
              id="clear-notications-form"
              class="pull-right">
            <button type="submit" class="btn btn-sm btn-link inline">
                <i class="icon-trash"></i>
            </button>
            @csrf
        </form>
    </li>
@endif

@forelse ($notifications as $notification)

    <li>
        <a href="{{$notification->data['action'] or '#'}}">
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
    </li>

@empty

    <div class="v-center" style="height: 80vh;">
        <h5 class="text-center w-full text-muted font-thin">{{trans('platform::common.no_notifications')}}</h5>
    </div>

@endforelse

@if(count($notifications) > 0)
    <li class="divider b-t b-dark"></li>
@endif
