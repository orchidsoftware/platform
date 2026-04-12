<div>
    <strong>{{ $notification->data['title'] ?? '' }}</strong>
    @if(!empty($notification->data['message']))
        <br><small class="text-muted">{{ $notification->data['message'] }}</small>
    @endif
</div>
