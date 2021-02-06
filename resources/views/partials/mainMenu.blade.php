@isset($title)
    <li class="nav-item mt-3 mb-1">
        <small class="text-muted ml-4 w-100">{{ __($title) }}</small>
    </li>
@endisset

<li class="nav-item @isset($active) {{active($active)}} @endisset">
    <a class="nav-link d-flex align-items-center"
       @if (!empty($withChildren))
       href="#menu-{{$slug}}" data-toggle="collapse"
       @else
       href="{{$route ?? '#'}}"
        @endif
    >

        @isset($icon)
            <x-orchid-icon :path="$icon" class="mr-2" width="1.15em" height="1.15em"/>
        @endisset

        {{ __($label) }}


        @isset($badge)
            <b class="badge badge-{{$badge['class']}} col-auto ml-auto">{{$badge['data']()}}</b>
        @endisset
    </a>
</li>

@if($withChildren)
    <div class="collapse sub-menu {{active($active,'show')}}" id="menu-{{$slug}}" data-parent="#headerMenuCollapse">
        {!! Dashboard::menu()->render($slug,'platform::partials.dropdownMenu') !!}
    </div>
@endif

@if($divider)
    <li class="divider my-2"></li>
@endif
