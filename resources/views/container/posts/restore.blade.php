<a href="#" onclick="event.preventDefault();document.getElementById('restore-post-form').submit();">
    {{trans('dashboard::common.alert.restore')}}
</a>

<form id="restore-post-form" class="hidden" action="{{ session('restore') }}" method="POST">
    {{ csrf_field() }}
</form>
