<div class="padder-v b-b">
    @isset($title)
        <h4 class="font-thin text-black">{{ __($title) }}</h4>
    @endisset
    <div class="row padder-v">
        @foreach($metrics as $key => $metric)
            <div class="col  @if(!$loop->last) b-r @endif">
                <p class="text-muted">{{ __($key) }}</p>
                <p class="h4 m-b-xs text-black font-thin">{{ $metric['keyValue'] }}</p>

                @if((float)$metric['keyDiff'] < 0)
                    <small class="text-danger">{{ $metric['keyDiff'] }} % <i class="icon-arrow-down"></i></small>
                @else
                    <small class="text-success">{{ $metric['keyDiff'] }} % <i class="icon-arrow-up"></i></small>
                @endif
            </div>
        @endforeach
    </div>
</div>