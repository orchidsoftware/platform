<button formaction="{{ url()->current() }}/{{ $notification->id }}/maskNotification" class="btn btn-link text-left">
    <i class="icon-circle text-{{ $notification->data['type'] }} @if($notification->read()) opacity @endif pull-left m-t-sm text-xs"></i>
    <span class="clear m-l-md block">
        {{$notification->data['title'] ?? ''}}
        <br>
        <small class="text-muted w-full w-b-k w-s-n">{{$notification->data['message'] ?? ''}}</small>
    </span>
</button>
