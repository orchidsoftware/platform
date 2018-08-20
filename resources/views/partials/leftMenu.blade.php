@if (!empty($childs))
    @isset($groupname)
        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">{{trans($groupname)}}</li>
    @endisset
    <li class="dropdown {{$class ?? ''}}">
        <a class="dropdown-toggle" type="button" id="dropdownMenu-{{$slug}}" data-toggle="dropdown" aria-haspopup="true"
           aria-expanded="false">
            <span class="pull-right text-muted">
                <i class="icon-arrow-right text-xs"></i>
            </span>
            @isset($badge)
                <b class="badge {{$badge['class']}} pull-right">{{$badge['data']()}}</b>
            @endisset
            <i class="{{$icon}}"></i>
            <span class="text-ellipsis">{{trans($label)}}</span>
        </a>
        <ul class="dropdown-menu dropdown-full dropdown-lvl" aria-labelledby="dropdownMenu-{{$slug}}">
            {!! Dashboard::menu()->render($slug) !!}
        </ul>
    </li>
    @isset($divider)
        <li class="divider b-t b-dark"></li>
    @endisset
@else
    @isset($groupname)
        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">{{trans($groupname)}}</li>
    @endisset
    <li class="{{$class ?? ''}}">
        <a href="{{$route}}">
            @isset($badge)
                <b class="badge {{$badge['class']}} pull-right">{{$badge['data']()}}</b>
            @endisset
            <i class="{{$icon}}"></i>
            <span class="text-ellipsis">{{trans($label)}}</span>
        </a>
    </li>
    @isset($divider)
        <li class="divider b-t b-dark"></li>
    @endisset
@endif