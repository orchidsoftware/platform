@isset($title)
    <li class="nav-item mt-3">
        <p class="hidden-folded my-1 text-muted text-sm ml-4 w-100">{{ __($title) }}</p>
    </li>
@endisset

<li class="nav-item @isset($active) {{active($active)}} @endisset">
    <a class="nav-link"
       @if (!empty($childs))
       href="#menu-{{$slug}}" data-toggle="collapse"
       @else
       href="{{$route ?? '#'}}"
        @endif
    >
        @isset($badge)
            <b class="badge bg-{{$badge['class']}} pull-right mr-2 mt-1">{{$badge['data']()}}</b>
        @endisset

        @isset($icon)
            <x-orchid-icon :path="$icon" class="mr-2"/>
        @endisset

        {{ __($label) }}
    </a>
</li>

@if($childs)
    <div class="collapse sub-menu {{active($active,'show')}}" id="menu-{{$slug}}" data-parent="#headerMenuCollapse">
        {!! Dashboard::menu()->render($slug,'platform::partials.dropdownMenu') !!}
    </div>
@endif

@if($divider)
    <li class="divider my-2"></li>
@endif
