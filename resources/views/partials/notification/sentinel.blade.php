@if($nextCursor)
    <div id="notification-sentinel"
         data-controller="notification"
         data-notification-url-value="{{ $url }}"
         data-notification-cursor-value="{{ $nextCursor }}"
    >
        <div class="d-flex align-content-center align-items-center fs-5 justify-content-center opacity-50">
            <div class="spinner-border" role="status">
                <span class="visually-hidden"></span>
            </div>
        </div>
    </div>
@else
    <div id="notification-sentinel"></div>
@endif
