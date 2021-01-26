<button formaction="{{ url()->current() }}/{{ $notification->id }}/maskNotification"
        type="submit"
        class="btn btn-link text-left p-4">

    <span class="align-self-start text-{{ $notification->data['type'] }} @if($notification->read()) opacity @endif pull-left m-t-sm text-xs">
        <x-orchid-icon path="circle" class="mr-2"/>
    </span>

    <span class="clear pl-3 d-block">
        <span class="w-100 w-b-k w-s-n">{{$notification->data['title'] ?? ''}}</span>
        <small class="text-muted pl-1">/ {{ $notification->created_at->diffForHumans() }}</small>
        <br>
        <small class="text-muted w-100 w-b-k w-s-n">{!! $notification->data['message'] ?? '' !!}</small>
    </span>
</button>
