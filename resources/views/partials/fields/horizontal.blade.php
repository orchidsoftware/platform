<div class="form-group row row-cols-sm-2 align-items-stretch">
    @if($field->has('title'))
        <label for="{{ $field->get('id') }}" class="col-sm-3 text-wrap form-label text-balance">
            {{ $field->get('title') }}

            <x-orchid-popover :content="$field->get('popover', '')"/>

            @if($field->get('required', false) && $field->get('showRequiredMark', true))
                <sup class="text-danger">*</sup>
            @endif
        </label>
    @endif

    <div class="col col-md-8">
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
            <small class="form-text text-muted">{!! $field->get('help') !!}</small>
        @endif
    </div>
</div>

@if($field->get('hr'))
    <div class="line line-dashed border-bottom my-3"></div>
@endif
