<div class="p-3 v-center">
    <div class="dropdown col p-0">
        <a href="#" class="nav-link p-0 v-center" data-toggle="dropdown">
            @if($image = Auth::user()->presenter()->image())
                <span class="thumb-sm avatar mr-3">
                        <img src="{{$image}}" class="b">
                </span>
            @endif
            <span style="width:11em;font-size: 0.85em;">
                <span class="text-ellipsis">{{Auth::user()->presenter()->title()}}</span>
                <span class="text-muted d-block text-ellipsis">{{Auth::user()->presenter()->subTitle()}}</span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow bg-white">

            {!! Dashboard::menu()->render('Profile','platform::partials.dropdownMenu') !!}

            @if(Dashboard::menu()->container->where('location','Profile')->isNotEmpty())
                <div class="dropdown-divider"></div>
            @endif

            @if(Auth::user()->hasAccess('platform.systems.index'))
                <a href="{{ route('platform.systems.index') }}" class="dropdown-item">
                    <x-orchid-icon path="settings" class="mr-2"/>
                    <span>{{ __('Systems') }}</span>
                </a>
            @endif

            @if(\Orchid\Access\UserSwitch::isSwitch())
                <a href="#"
                   class="dropdown-item"
                   data-controller="layouts--form"
                   data-action="layouts--form#submitByForm"
                   data-layouts--form-id="return-original-user"
                >
                    <x-orchid-icon path="logout" class="mr-2"/>
                    <span>{{ __('Back to my account') }}</span>
                </a>
                <form id="return-original-user"
                      class="hidden"
                      data-controller="layouts--form"
                      data-action="layouts--form#submit"
                      action="{{ route('platform.switch.logout') }}"
                      method="POST">
                    @csrf
                </form>
            @else
                <a href="{{ route('platform.logout') }}"
                   class="dropdown-item"
                   data-controller="layouts--form"
                   data-action="layouts--form#submitByForm"
                   data-layouts--form-id="logout-form"
                   dusk="logout-button">
                    <x-orchid-icon path="logout" class="mr-2"/>

                    <span>{{ __('Sign out') }}</span>
                </a>
                <form id="logout-form"
                      class="hidden"
                      action="{{ route('platform.logout') }}"
                      method="POST"
                      data-controller="layouts--form"
                      data-action="layouts--form#submit"
                >
                    @csrf
                </form>
            @endif

        </div>
    </div>

    @include('platform::partials.notificationProfile')
</div>
