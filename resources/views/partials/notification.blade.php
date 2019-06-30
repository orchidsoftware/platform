<button formaction="{{ url()->current() }}/{{ $notification->id }}/maskNotification" class="btn text-left d-flex">
    <i class="icon-circle text-{{ $notification->data['type'] }} @if($notification->read()) opacity @endif pull-left m-t-sm text-xs"></i>
    <span class="clear m-l-md">
        {{$notification->data['title'] ?? ''}}
        <small class="block text-muted">{{$notification->data['message'] ?? ''}}</small>
    </span>
</button>