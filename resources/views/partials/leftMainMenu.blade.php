@if(!empty($childs) && Dashboard::menu()->container->where('location',$slug)->count())
    @isset($groupname)
        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">{{trans($groupname)}}</li>
    @endisset

    <li class="@isset($active) {{active($active)}} @endisset">
        <a href="{{$route ?? '#'}}">
            @isset($badge)
                <b class="badge {{$badge['class']}} pull-right">{{$badge['data']()}}</b>
            @endisset
            <i class="{{$icon}}"></i>
            <span>{{trans($label)}}</span>
            @if (!empty($childs))
                <span class="pull-right text-muted">
                    <i class="icon-arrow-right text"></i>
                    <i class="icon-arrow-down text-active"></i>
            </span>
            @endif
        </a>
        @if (!empty($childs))
            <ul class="nav nav-sub dker">
                {!! Dashboard::menu()->render($slug) !!}
            </ul>
        @endif
    </li>

    @isset($divider)
        <li class="divider b-t b-dark"></li>
    @endisset

@endif

