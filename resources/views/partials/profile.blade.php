<div class="profile-container d-flex align-items-center p-3 rounded lh-sm position-relative overflow-hidden">

    <a href="{{ route(config('orchid.profile', 'orchid.profile')) }}" class="d-flex align-items-center gap-3 overflow-hidden grow min-w-0">
        @if($image = Auth::user()->presenter()->image())
            <img src="{{$image}}" alt="{{ Auth::user()->presenter()->title()}}" class="thumb-sm avatar b shrink-0" type="image/*">
        @endif

        <small class="d-flex flex-column lh-1 min-w-0">
            <span class="text-ellipsis text-white">{{Auth::user()->presenter()->title()}}</span>
            <span class="text-ellipsis text-muted">{{Auth::user()->presenter()->subTitle()}}</span>
        </small>
    </a>

    <div class="d-flex align-items-center shrink-0 ms-auto">
        <button class="btn btn-link px-1 py-0 link-body-emphasis"
                data-action="click->theme#toggle"
                title="{{ __('Toggle theme') }}">
            <span class="theme-icon-light">
                <x-orchid-icon path="bs.sun"/>
            </span>
            <span class="theme-icon-dark">
                <x-orchid-icon path="bs.moon-stars"/>
            </span>
        </button>

        <x-orchid-notification/>
    </div>

</div>
