<div class="dropdown pull-right text-center">
    <a class="nav-link icon no-padder" data-toggle="dropdown">
        <i class="icon-bell"></i>
        @if(count($notifications) > 0)
            <span class="badge badge-sm up bg-danger pull-right-xs text-white">
                {{ count($notifications) < 10 ? count($notifications) : '+'}}
            </span>
        @endif
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow bg-white">

        @if(count($notifications) > 0)
            <div class="hidden-folded padder m-t-xs m-b-sm text-muted text-xs">
                {{ __('Notifications') }}
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
            <p class="text-center m-0 w-full text-muted font-thin">{{ __('No notifications') }}</p>
        </div>

        @endforelse

        @if(count($notifications) > 0)
            <div class="dropdown-divider"></div>


            <form action="{{route('platform.notification.read')}}"
                  data-controller="layouts--form"
                  data-action="layouts--form#submit"
                  method="post"
                  id="clear-notications-form">
                <button type="submit" class="btn btn-sm btn-link inline dropdown-item text-center text-muted-dark">
                    <i class="icon-trash"></i> {{ __('Mark all as read') }}
                </button>
                @csrf
            </form>
        @endif

    </div>
</div>

