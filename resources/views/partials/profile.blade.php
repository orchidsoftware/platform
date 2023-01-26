<div class="d-flex align-items-center p-3 rounded lh-sm" style="background: rgb(19 20 21)">

    <a href="{{ route('platform.profile') }}" class="col-10 d-flex align-items-center me-3">
        @if($image = Auth::user()->presenter()->image())
            <span class="thumb-sm avatar me-3">
                  <img src="{{$image}}" class="b">
            </span>
        @endif
        <small class="d-flex flex-column">
            <span class="text-ellipsis text-white">{{Auth::user()->presenter()->title()}}</span>
            <span class="text-ellipsis text-muted">{{Auth::user()->presenter()->subTitle()}}</span>
        </small>
    </a>

    <x-orchid-notification/>
</div>
