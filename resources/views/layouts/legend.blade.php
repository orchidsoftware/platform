<fieldset class="mb-3">

    @empty(!$title)
        <div class="col p-0 px-3">
            <legend class="text-body-emphasis mt-2 mx-2">
                {{ $title }}
            </legend>
        </div>
    @endempty

    <dl class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
        @foreach($columns as $column)
            <div class="d2-grid py-3 {{ $loop->first ? '' : 'border-top' }}">
                <dt class="text-muted fw-normal me-3">
                    {!! $column->buildDt($repository) !!}
                </dt>
                <dd class="text-body-emphasis">
                    {!! $column->buildDd($repository) !!}
                </dd>
            </div>
        @endforeach
    </dl>
</fieldset>
