<div class="mb-3">
    @isset($title)
        <legend class="text-black px-4 mb-0">
            {{ __($title) }}
        </legend>
    @endisset
    <div class="row mb-2 g-3 g-mb-4">
        @foreach($metrics as $key => $metric)
            <div class="col">
                <div class="p-4 bg-white rounded shadow-sm h-100 d-flex flex-column">
                    <small class="text-muted d-block mb-1">{{ __($key) }}</small>
                    <p class="h3 text-black fw-light mt-auto">
                        {{ is_array($metric) ? $metric['value'] : $metric }}

                        @if(isset($metric['diff']) && (float)$metric['diff'] !== 0.0)
                            <small class="small {{ (float)$metric['diff'] < 0 ? 'text-danger': 'text-success' }}">
                                {{ round($metric['diff'], 2) }} %
                            </small>
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
