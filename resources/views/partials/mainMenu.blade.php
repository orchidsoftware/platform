@isset($title)
    <li class="nav-item mt-3 mb-1">
        <small class="text-muted ms-4 w-100">{{ __($title) }}</small>
    </li>
@endisset

<li class="nav-item @isset($active) {{active($active)}} @endisset">
    <a class="nav-link d-flex align-items-center"
       @if (!empty($withChildren))
       href="#menu-{{$slug}}" data-bs-toggle="collapse"
       @else
       href="{{$route ?? '#'}}"
        @endif
    >

        @isset($icon)
            <x-orchid-icon :path="$icon" class="me-2" width="1.15em" height="1.15em"/>
        @endisset

        {{ __($label) }}


        @isset($badge)
            <b class="badge bg-{{$badge['class']}} col-auto ms-auto">{{$badge['data']()}}</b>
        @endisset
    </a>
</li>

@if($withChildren)
    <div class="collapse sub-menu {{active($active,'show')}}" id="menu-{{$slug}}" data-bs-parent="#headerMenuCollapse">
        {!! Dashboard::menu()->render($slug,'platform::partials.dropdownMenu') !!}
    </div>
@endif

@if($divider)
    <li class="divider my-2"></li>
@endif
