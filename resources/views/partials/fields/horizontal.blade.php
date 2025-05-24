<div class="form-group row row-cols-sm-2 align-items-stretch">
    @if($field->has('title'))
        <label for="{{ $field->get('id') }}" class="col-sm-3 text-wrap form-label">
            {{ $field->get('title') }}

            <x-orchid-popover :content="$field->get('popover', '')"/>

            @if($field->get('required', false))
                <sup class="text-danger">*</sup>
            @endif
        </label>
    @endif

    <div class="col col-md-8">
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
                <small>{{$errors->first($field->getOldName())}}</small>
            </div>
        @elseif($field->has('help'))
            <small class="form-text text-muted">{!! $field->get('help') !!}</small>
        @endif
    </div>
</div>

@if($field->get('hr'))
    <div class="line line-dashed border-bottom my-3"></div>
@endif
