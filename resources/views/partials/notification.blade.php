<button formaction="{{ url()->current() }}/{{ $notification->id }}/maskNotification" class="btn btn-link text-left p-4">
    <i class="icon-circle text-{{ $notification->data['type'] }} @if($notification->read()) opacity @endif pull-left m-t-sm text-xs"></i>
    <span class="clear pl-3 block">
        <span class="w-full w-b-k w-s-n">{{$notification->data['title'] ?? ''}}</span>
        <small class="text-muted pl-1">/ {{ $notification->created_at->diffForHumans() }}</small>
        <br>
        <small class="text-muted w-full w-b-k w-s-n">{!! $notification->data['message'] ?? '' !!}</small>
    </span>
</button>
