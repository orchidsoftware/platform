<div class="wrapper v-center">
    <div class="dropdown col no-padder">
        <a href="#" class="nav-link p-0 v-center" data-toggle="dropdown">
                    <span class="thumb-xs avatar m-r-xs">
                        <img src="{{Auth::user()->getAvatar()}}" class="b b-dark bg-light" alt="test">
                    </span>
            <span class="ml-2" style="width:125px;font-size: 0.82857rem;">
                <span class="text-ellipsis">{{Auth::user()->getNameTitle()}}</span>
                <span class="text-muted d-block text-ellipsis">{{Auth::user()->getSubTitle()}}</span>
            </span>
        </a>
        <div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow bg-white">

            {!! Dashboard::menu()->render('Profile','platform::partials.dropdownMenu') !!}

            @if(Dashboard::menu()->container->where('location','Profile')->isNotEmpty())
                <div class="dropdown-divider"></div>
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
                   data-controller="layouts--form"
                   data-action="layouts--form#submitByForm"
                   data-layouts--form-id="return-original-user"
                >
                    <i class="icon-logout m-r-xs" aria-hidden="true"></i>
                    <span>{{ __('Back to my account') }}</span>
                </a>
                <form id="return-original-user"
                      class="hidden"
                      data-controller="layouts--form"
                      data-action="layouts--form#submit"
                      action="{{ route('platform.systems.users.edit',[Auth::user(),'switchUserStop']) }}"
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
                    <i class="icon-logout m-r-xs" aria-hidden="true"></i>
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
    @include('platform::partials.notifications')
</div>