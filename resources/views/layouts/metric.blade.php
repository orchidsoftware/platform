<div class="mb-3">
    @isset($title)
        <legend class="text-black px-4 mb-0">
            {{ __($title) }}
        </legend>
    @endisset
    <div class="row mb-2 g-3 g-mb-4">
        @foreach($metrics as $key => $metric)
            <div class="col">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <small class="text-muted d-block mb-1">{{ __($key) }}</small>
                    <p class="h3 text-black fw-light">{{ $metric['keyValue'] }}
                        @if(isset($metric['keyDiff']) && (float)$metric['keyDiff'] !== 0.0)
                            <small class="small {{ (float)$metric['keyDiff'] < 0 ? 'text-danger': 'text-success' }}">
                                {{ $metric['keyDiff'] }} %
                            </small>
                        @endif
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>
