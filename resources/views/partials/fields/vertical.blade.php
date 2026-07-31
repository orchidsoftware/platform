<div class="form-group">
    @if($field->has('title'))
        <label for="{{ $field->get('id') }}" class="form-label text-balance">
            {{ $field->get('title') }}

            @if($field->get('required', false) && $field->get('showRequiredMark', true))
                <sup class="text-danger">*</sup>
            @endif

            <x-orchid-popover :content="$field->get('popover', '')"/>
        </label>
    @endif

    {!! $slot !!}

    @php
        // Backport for consistent error handling behavior between Laravel 10 and 11.
        // This implementation will be modified in a future major version.

        if ($errors instanceof \Illuminate\Support\ViewErrorBag) {
            $errors = $errors->getBag('default');
        }
    @endphp

    @if($errors->has($field->getOldName()))
        <div class="invalid-feedback d-block text-balance">
            <small>{{ $errors->first($field->getOldName()) }}</small>
        </div>
    @elseif($field->has('help'))
        <small class="form-text text-muted">
            {!! $field->get('help') !!}
        </small>
    @endif
</div>

@if($field->get('hr'))
    <div class="line line-dashed border-bottom my-3"></div>
@endisset
