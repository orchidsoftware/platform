<div class="dropdown d-none d-md-flex">
    <a class="nav-link icon" data-toggle="dropdown">
        <i class="icon-bell"></i>
        @if(count($notifications) > 0)
            <span class="badge badge-sm up bg-danger pull-right-xs text-white">
                {{ count($notifications) < 10 ? count($notifications) : '+'}}
            </span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">


        @if(count($notifications) > 0)
            <div class="hidden-folded padder m-t m-b-sm text-muted text-xs">
                {{trans('platform::common.notifications')}}
            </div>
        @endif

        @forelse ($notifications as $notification)

            <a href="{{$notification->data['action'] ?? '#'}}" class="dropdown-item d-flex">
                <i class="icon-circle {{ $notification->data['type'] }} pull-left m-t-sm text-xs"></i>
                <span class="clear m-l-md">
                    @if($notification->read())
                            <span>{{$notification->data['title'] ?? ''}}</span>
                        @else
                            {{$notification->data['title'] ?? ''}}
                    @endif
                    <small class="text-muted clear text-ellipsis">{{$notification->data['message'] ?? ''}}</small>
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

    </div>
</div>




