<div class="d-flex m-0 align-items-center p-3">
    <div class="dropdown w-75">
        <a href="#" class="nav-link p-0 d-flex align-items-center" data-bs-toggle="dropdown">
            @if($image = Auth::user()->presenter()->image())
                <span class="thumb-sm avatar me-3">
                        <img src="{{$image}}" class="b">
                </span>
            @endif
            <span class="d-block small">
                <span class="text-ellipsis text-white" style="max-width: 12em;">{{Auth::user()->presenter()->title()}}</span>
                <span class="text-muted d-block text-ellipsis">{{Auth::user()->presenter()->subTitle()}}</span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow bg-white">

            @unless(Dashboard::isEmptyMenu(\Orchid\Platform\Dashboard::MENU_PROFILE))
                {!! Dashboard::renderMenu(\Orchid\Platform\Dashboard::MENU_PROFILE) !!}
                <div class="dropdown-divider"></div>
            @endunless

            @if(\Orchid\Access\UserSwitch::isSwitch())
                <a href="#"
                   class="dropdown-item"
                   data-controller="form"
                   data-action="form#submitByForm"
                   data-form-id="return-original-user"
                >
                    <x-orchid-icon path="people" class="me-2"/>
                    <span>{{ __('Back to my account') }}</span>
                </a>
                <form id="return-original-user"
                      class="hidden"
                      data-controller="form"
                      data-action="form#submit"
                      action="{{ route('platform.switch.logout') }}"
                      method="POST">
                    @csrf
                </form>
            @endif

            <a href="{{ route('platform.logout') }}"
               class="dropdown-item"
               data-controller="form"
               data-action="form#submitByForm"
               data-form-id="logout-form"
               dusk="logout-button">
                <x-orchid-icon path="logout" class="me-2"/>

                <span>{{ __('Sign out') }}</span>
            </a>
            <form id="logout-form"
                  class="hidden"
                  action="{{ route('platform.logout') }}"
                  method="POST"
                  data-controller="form"
                  data-action="form#submit"
            >
                @csrf
            </form>
        </div>
    </div>

    <x-orchid-notification/>
</div>
