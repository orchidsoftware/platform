<div class="form-group mb-0">
    {!! $slot !!}

    @if($field->has('help'))
        <small class="form-text text-muted">
            {!! $field->get('help') !!}
        </small>
    @endif
</div>
