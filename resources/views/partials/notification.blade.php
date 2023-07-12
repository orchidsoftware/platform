<button formaction="{{ url()->current() }}/{{ $notification->id }}/maskNotification"
        type="submit"
        class="btn btn-link text-start p-4 d-flex align-items-baseline">

    <small class="align-self-start me-2 text-{{ $notification->data['type'] }} @if($notification->read()) opacity @endif">
        <x-orchid-icon path="bs.circle-fill"/>
    </small>

    <span class="ps-3 text-wrap text-break">
        <span class="w-100">{{$notification->data['title'] ?? ''}}</span>
        <small class="text-muted ps-1 d-inline d-md-none">/ {{ $notification->created_at->diffForHumans() }}</small>
        <br>
        <small class="text-muted w-100">
            {!! $notification->data['message'] ?? '' !!}
        </small>
    </span>

    <small class="text-muted col-3 ms-auto d-none d-md-block text-end">
         {{ $notification->created_at->diffForHumans() }}
    </small>
</button>
