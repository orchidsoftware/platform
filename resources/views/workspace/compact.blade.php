@extends('platform::app')

@section('body')

    <div class="container-md p-0">
        <div class="workspace mt-3 mt-md-4 mb-4 mb-md-0 d-flex flex-column overflow-hidden">
            @yield('workspace')
        </div>
    </div>

@endsection
