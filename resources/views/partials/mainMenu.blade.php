{{-- @if(!empty($childs) && Dashboard::menu()->showCountElement($slug)) --}}

@isset($title)
    <li class="nav-item mt-3">
        <div class="hidden-folded padder mt-1 mb-1 text-muted text-xs m-l">{{ __($title) }}</div>
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
            <b class="badge bg-{{$badge['class']}} pull-right mr-3">{{$badge['data']()}}</b>
        @endisset
        <i class="{{$icon}} mr-2"></i>{{ __($label) }}
    </a>
</li>
@if($childs)
    <div class="collapse sub-menu {{active($active,'show')}}" id="menu-{{$slug}}" data-parent="#headerMenuCollapse">
        {!! Dashboard::menu()->render($slug,'platform::partials.dropdownMenu') !!}
    </div>
@endif
@if($divider)
    <li class="divider b-t b-dark"></li>
@endif
{{-- @endif --}}
