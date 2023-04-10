@props(['target', 'action', 'push'])

@if(\Orchid\Support\Facades\Dashboard::isPartialRequest())
    @fragment($target)
        <turbo-stream target="{{ $target }}" action="{{ $action ?? 'replace' }}">
            <template>
                {!! $slot !!}
            </template>
        </turbo-stream>
    @endfragment
@elseif(!empty($push))
    @push($push)
        {!! $slot !!}
    @endpush
@else
    {!! $slot !!}
@endif
