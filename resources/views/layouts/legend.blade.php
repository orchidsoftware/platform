<fieldset class="mb-3" data-async>

    @empty(!$title)
        <div class="col p-0 px-3">
            <legend class="text-black">
                {{ $title }}
            </legend>
        </div>
    @endempty

    <div class="bg-white rounded shadow-sm p-4 py-4 d-flex flex-column">
        <dl class="d-block m-0">
            @foreach($columns as $column)
                <div class="d2-grid py-3 {{ $loop->first ? '' : 'border-top' }}">
                    <dt class="text-muted fw-normal">
                        {!! $column->buildDt($repository) !!}
                    </dt>
                    <dd class="text-black">
                        {!! $column->buildDd($repository) !!}
                    </dd>
                </div>
            @endforeach
        </dl>
    </div>
</fieldset>
