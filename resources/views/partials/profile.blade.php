<div class="wrapper v-center">
    <div class="dropdown">
        <a href="#" class="nav-link p-0 v-center" data-toggle="dropdown">
                    <span class="thumb-xs avatar m-r-xs">
                        <img src="{{Auth::user()->getAvatar()}}" class="b b-dark bg-light" alt="test">
                    </span>
            <span class="ml-2" style="width:140px;font-size: 0.82857rem;">
                <span class="text-ellipsis">{{Auth::user()->getNameTitle()}}</span>
                <span class="text-muted d-block text-ellipsis">{{Auth::user()->getSubTitle()}}</span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow bg-white">
            {!! Dashboard::menu()->render('Profile','platform::partials.dropdownMenu') !!}

            <div class="dropdown-divider"></div>

            @if(!is_null(config('platform.support')))
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#support">
                    <i class="m-r-xs icon-help"></i> {{ __('Need help?') }}
                </a>
            @endif

            @if(Auth::user()->hasAccess('platform.systems.index'))
                <a href="{{ route('platform.systems.index') }}" class="dropdown-item">
                    <i class="icon-settings m-r-xs" aria-hidden="true"></i>
                    <span>{{ __('Systems') }}</span>
                </a>
            @endif

            @if(session()->has('original_user'))
                <a href="{{route('platform.systems.users')}}"
                   class="dropdown-item"
                   onclick="event.preventDefault();document.getElementById('return-original-user').submit();"
                >
                    <i class="icon-logout m-r-xs" aria-hidden="true"></i>
                    <span>{{ __('Back to my account') }}</span>
                </a>
                <form id="return-original-user" class="hidden"
                      action="{{ route('platform.systems.users.edit',[Auth::user(),'switchUserStop']) }}"
                      method="POST">
                    @csrf
                </form>
            @else
                <a href="{{ route('platform.logout') }}"
                   class="dropdown-item"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();"
                   dusk="logout-button">
                    <i class="icon-logout m-r-xs" aria-hidden="true"></i>
                    <span>{{ __('Sign out') }}</span>
                </a>
                <form id="logout-form" class="hidden" action="{{ route('platform.logout') }}"
                      method="POST">
                    @csrf
                </form>
            @endif

        </div>
    </div>
    @include('platform::partials.notifications')
</div>