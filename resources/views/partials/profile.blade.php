<div class="row m-0 align-items-center p-3">
    <div class="dropdown col p-0">
        <a href="#" class="nav-link p-0 d-flex align-items-center" data-bs-toggle="dropdown">
            @if($image = Auth::user()->presenter()->image())
                <span class="thumb-sm avatar me-3">
                        <img src="{{$image}}" class="b">
                </span>
            @endif
            <span style="width:12em;font-size: 0.85em;">
                <span class="text-ellipsis">{{Auth::user()->presenter()->title()}}</span>
                <span class="text-muted d-block text-ellipsis">{{Auth::user()->presenter()->subTitle()}}</span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow bg-white">

            {!! Dashboard::menu()->render('Profile','platform::partials.dropdownMenu') !!}

            @if(Dashboard::menu()->container->where('location','Profile')->isNotEmpty())
                <div class="dropdown-divider"></div>
            @endif

            @if(\Orchid\Access\UserSwitch::isSwitch())
                <a href="#"
                   class="dropdown-item"
                   data-controller="layouts--form"
                   data-action="layouts--form#submitByForm"
                   data-layouts--form-id="return-original-user"
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
