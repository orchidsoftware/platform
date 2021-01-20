<div class="bg-white rounded shadow-sm mb-3 p-4">
    @isset($title)
        <h4 class="font-weight-light text-black mb-3">{{ __($title) }}</h4>
    @endisset
    <div class="row mb-2">
        @foreach($metrics as $key => $metric)
            <div class="col-sm col-6 mb-3 mb-sm-0  @if(!$loop->last) border-right @endif">
                <small class="text-muted d-block mb-1">{{ __($key) }}</small>
                <p class="h4 mb-1 text-black font-weight-light">{{ $metric['keyValue'] }}</p>

                @isset($metric['keyDiff'])
                    @if((float)$metric['keyDiff'] < 0)
                        <small class="text-xs text-danger">{{ $metric['keyDiff'] }} %
                            <x-orchid-icon path="arrow-down" class="v-top"/>
                        </small>
                    @elseif((float)$metric['keyDiff'] == 0)
                        <small class="text-xs text-muted">
                            —
                        </small>
                    @else
                        <small class="text-xs text-success">{{ $metric['keyDiff'] }} %
                            <x-orchid-icon path="arrow-up" class="v-top"/>
                        </small>
                    @endif
                @endisset
            </div>
        @endforeach
    </div>
</div>
