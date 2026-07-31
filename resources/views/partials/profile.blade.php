<div class="profile-container d-flex align-items-stretch p-3 rounded lh-sm position-relative overflow-hidden">

    <a href="{{ route(config('orchid.profile', 'orchid.profile')) }}" class="col-10 d-flex align-items-center gap-3">
        @if($image = Auth::user()->presenter()->image())
            <img src="{{$image}}"  alt="{{ Auth::user()->presenter()->title()}}" class="thumb-sm avatar b" type="image/*">
        @endif

        <small class="d-flex flex-column lh-1 col-9">
            <span class="text-truncate text-white">{{Auth::user()->presenter()->title()}}</span>
            <span class="text-truncate text-muted">{{Auth::user()->presenter()->subTitle()}}</span>
        </small>
    </a>

    <x-orchid-notification/>

</div>
