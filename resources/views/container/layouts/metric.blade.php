<div class="m-b">
    <div class="wrapper">
        <h4 class="font-thin text-black">{{ trans($title) }}</h4>
        <div class="row padder-v">
            @foreach($metrics as $key => $metric)
                <div class="col b-r">
                    <p class="text-muted">{{ trans($key) }}</p>
                    <p class="h3 m-b-xs text-black font-thin">{{ $metric['keyValue'] }}</p>

                    @if((float)$metric['keyDiff'] < 0)
                        <p class="text-danger">{{ $metric['keyDiff'] }} % <i class="icon-arrow-down"></i></p>
                    @else
                        <p class="text-success">{{ $metric['keyDiff'] }} % <i class="icon-arrow-up"></i></p>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
</div>