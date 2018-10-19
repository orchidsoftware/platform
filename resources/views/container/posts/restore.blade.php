<a href="#" onclick="event.preventDefault();document.getElementById('restore-post-form').submit();">
    {{__('Restore the record.')}}
</a>

<form id="restore-post-form" class="hidden" action="{{ session('restore') }}" method="POST">
    @csrf
</form>
