@extends('platform::app')

@section('body')

    <div class="p-0 h-100">
        <div class="workspace pt-3 pt-md-4 mb-4 mb-md-0 d-flex flex-column h-100">
            @yield('workspace')

            @includeFirst([config('platform.template.footer'), 'platform::footer'])
        </div>
    </div>

@endsection
