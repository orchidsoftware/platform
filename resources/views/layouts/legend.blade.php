<div class="bg-white rounded shadow-sm mb-3">
    <dl class="d-block p-4 m-0">
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
