@php
    $isPaginated  = request()->has('cursor');
    $nextCursor   = $notifications->hasMorePages() ? $notifications->nextCursor()?->encode() : null;
    $url          = route('orchid.notifications.index');
@endphp

@if($isPaginated)
    {{-- Cursor load: insert items before the sentinel, then swap the sentinel --}}

    <x-orchid-stream rule="true" target="notification-sentinel" action="before">
        @each('orchid::partials.notification.item', $notifications, 'notification')
    </x-orchid-stream>

    <x-orchid-stream rule="true" target="notification-sentinel" action="replace">
        @include('orchid::partials.notification.sentinel')
    </x-orchid-stream>

@else
    {{-- Initial load: replace the list and update the footer --}}

    <x-orchid-stream rule="true" target="orchid-notifications" action="replace">
        <form id="orchid-notifications" class="position-relative d-flex flex-column gap-4">

            @forelse($notifications as $notification)
                @include('orchid::partials.notification.item', ['notification' => $notification])
            @empty
                <x-orchid-empty-state
                    icon="bs.bell"
                    :description="__('No new notifications.')"
                />
            @endforelse

            @include('orchid::partials.notification.sentinel')

        </form>
    </x-orchid-stream>

    <x-orchid-stream rule="true" target="orchid-notifications-footer" action="replace">
        <div id="orchid-notifications-footer" @if($notifications->isEmpty()) hidden @endif>
            @if($notifications->isNotEmpty())
                <div class="d-flex align-items-center gap-2">
                    <form action="{{ route('orchid.notifications.markAllAsRead') }}" method="post">
                        @csrf
                        <button type="submit"
                                class="btn btn-sm btn-link text-decoration-none">
                            {{ __('Mark All As Read') }}
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-orchid-stream>

@endif
