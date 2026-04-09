<div class="d-flex align-items-baseline position-relative {{ $notification->read() ? 'opacity-50' : '' }}">
    <button
        formmethod="POST"
        formaction="{{ route('orchid.notifications.markAsRead', $notification) }}"
        type="submit"
        class="stretched-link position-absolute top-0 start-0 w-100 h-100 opacity-0">
    </button>

    <small class="align-self-start me-2 text-{{ $notification->data['type'] }} @if($notification->read()) opacity @endif">
        <x-orchid-icon path="bs.circle-fill"/>
    </small>

    <span class="ps-3 text-wrap text-break">
        <span class="w-100">{{ $notification->data['title'] ?? '' }}</span>
        <small class="text-muted ps-1 d-inline d-md-none">
            / {{ $notification->created_at->diffForHumans() }}
        </small>
        <br>
        <small class="text-muted w-100">
            {!! $notification->data['message'] ?? '' !!}
        </small>
    </span>

    <small class="text-muted col-3 ms-auto d-none d-md-block text-end">
        {{ $notification->created_at->diffForHumans() }}
    </small>
</div>
