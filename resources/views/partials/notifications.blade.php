@php
    $notifications = Auth::user()->unreadNotifications->where('type',\Orchid\Platform\Notifications\DashboardNotification::class);
@endphp

<div class="tab-pane fade in nav show"
  role="tabpanel"
  id="menu-notifications"
  aria-labelledby="notise-tab">

@if(count($notifications) > 0)
     <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">Notications
        <form action="{{route('dashboard.notification.read')}}"
              method="post"
              id="clear-notications-form"
              class="pull-right">
            <button type="submit" class="btn btn-sm btn-link inline">
                <i class="icon-trash"></i>
            </button>
            {{ csrf_field() }}
        </form>
    </li>
 @endif

@forelse ($notifications as $notification)

<li>
    <a href="{{$notification->data['action'] or '#'}}">
          <i class="fa fa-circle {{ $notification->data['type'] }} pull-left m-t-sm text-sm"></i>
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
    <h5 class="text-center w-full text-muted font-thin">No notifications</h5>
</div>

@endforelse

@if(count($notifications) > 0)
 <li class="divider b-t b-dark"></li>
@endif

</div>
