<a href="{{$notification->data['action'] ?? '#'}}" class="d-flex">
    <i class="icon-circle {{ $notification->data['type'] }} @if($notification->read_at) opacity @endif pull-left m-t-sm text-xs"></i>
    <span class="clear m-l-md">
        @if($notification->read())
            <span>{{$notification->data['title'] ?? ''}}</span>
        @else
            {{$notification->data['title'] ?? ''}}
        @endif
            <small class="block text-muted">{{$notification->data['message'] ?? ''}}</small>
    </span>
</a>