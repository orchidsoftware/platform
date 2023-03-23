<turbo-stream target="{{ $target }}" action="{{ $action }}">
    <template>
        {!! $template !!}
    </template>
</turbo-stream>

@if($state !== null)
    <turbo-stream target="screen-state" action="replace">
        <template>
            <input type="hidden" name="_state" id="screen-state" value="{{ $state }}">
        </template>
    </turbo-stream>
@endisset
