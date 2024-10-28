<div class="d-flex flex-column grid d-md-grid form-group {{ $align }}"
    @style([
        '--bs-columns: '.count($group),
        'grid-template-columns: '. $gridTemplateColumns => $gridTemplateColumns !== null,
    ])>
    @foreach($group as $field)
        <div class="{{ $class }}
                    {{ $loop->first && $itemToEnd ? 'ms-auto': '' }}
            ">
            {!! $field !!}
        </div>
    @endforeach
</div>
