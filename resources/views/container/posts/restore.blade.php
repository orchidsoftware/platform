@section('flash_notification.sub_message')
    @includeWhen(session('restore'),'platform::container.posts.restore')
@stop