@extends('platform::app')

@section('body')

    <div class="mt-3 mt-md-4 workspace">
        @yield('workspace')
        
        @includeFirst([config('platform.template.footer'), 'platform::footer'])
    </div>

@endsection
