<div class="profile-container d-flex align-items-stretch p-3 rounded lh-sm position-relative overflow-hidden">

    <a href="{{ route(config('platform.profile', 'platform.profile')) }}" class="col-10 d-flex align-items-center me-3">
        @if($image = Auth::user()->presenter()->image())
            <img src="{{$image}}"  alt="{{ Auth::user()->presenter()->title()}}" class="thumb-sm avatar b me-3" type="image/*">
        @endif

        <small class="d-flex flex-column lh-1 col-9">
            <span class="text-ellipsis text-white">{{Auth::user()->presenter()->title()}}</span>
            <span class="text-ellipsis text-muted">{{Auth::user()->presenter()->subTitle()}}</span>
        </small>
    </a>

    <x-orchid-notification/>

</div>
