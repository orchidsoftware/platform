@if(isset($childs) && $childs)
    @if(isset($groupname))
        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">{{$groupname}}</li>
    @endif
    <li class="dropdown">
        <a class="dropdown-toggle" type="button" id="dropdownMenu-{{$slug}}" data-toggle="dropdown" aria-haspopup="true"
           aria-expanded="false">
    <span class="pull-right text-muted">
    <i class="fa fa-fw fa-angle-right text"></i>
    </span>
            @if(isset($badge))
                <b class="label {{$badge['class']}} pull-right">{{$badge['data']()}}</b>
            @endif
            <i class="{{$icon}}"></i>
            <span class="text-ellipsis" title="{{$label}}">{{$label}}</span>
        </a>
        <ul class="dropdown-menu dropdown-full dropdown-lvl" aria-labelledby="dropdownMenu-{{$slug}}">
            {!! Dashboard::menu()->render($slug) !!}
        </ul>
    </li>
    @if(isset($divider) && $divider == true)
        <li class="divider"></li>
    @endif
@else
    @if(isset($groupname))
        <li class="hidden-folded padder m-t m-b-sm text-muted text-xs">{{$groupname}}</li>
    @endif
    <li>
        <a href="{{$route}}">

            @if(isset($badge))
                <b class="label {{$badge['class']}} pull-right">{{$badge['data']()}}</b>
            @endif
            <i class="{{$icon}}"></i>
            <span title="{{$label}}" class="text-ellipsis">{{$label}}</span>
        </a>
    </li>
    @if(isset($divider) && $divider == true)
        <li class="divider"></li>
    @endif
@endif
