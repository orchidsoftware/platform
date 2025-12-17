<div class="form-group">
    @if($field->has('title'))
        <label for="{{ $field->get('id') }}" class="form-label text-balance">
            {{ $field->get('title') }}

            @if($field->get('required', false))
                <sup class="text-danger">*</sup>
            @endif

            <x-orchid-popover :content="$field->get('popover', '')"/>
        </label>
    @endif

    {!! $slot !!}

    @php
        // Backport for consistent error handling behavior between Laravel 10 and 11.
        // This implementation will be modified in a future major version.

        // Retrieve all errors from the $errors object and convert them into a collection
        $allErrors = collect($errors->all());

        // Check if there is a 'default' error key in the collection of errors
        if ($allErrors->has('default')) {
            // If a 'default' error exists, assign it to the $errors variable
            $errors = $allErrors->get('default');
        }
    @endphp

    @if($errors->has($field->getOldName()))
        <div class="invalid-feedback d-block">
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
