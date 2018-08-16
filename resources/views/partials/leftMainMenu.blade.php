@isset($childs)
    @if(Dashboard::menu()->container->where('location',$slug)->count())
        <li role="presentation" class="nav-item @isset($active) {{active($active)}} @endisset">
            <a href="#{{$slug}}" id="{{$slug}}-tab" class="nav-link" role="tab" data-toggle="tab">
                <i class="{{$icon}}">
                    @isset($badge)
                        <b class="badge {{$badge['class']}} pos-abt pull-bottom">{{$badge['data']()}}</b>
                    @endisset
                </i>
                <span>{{$label}}</span>
            </a>
        </li>
    @endif
@else
    <li class="@isset($childs) dropdown-item @endisset @isset($active) {{active($active)}} @endisset">
        <a href="{{$route}}">
            <i class="{{$icon}}">
                @isset($badge)
                <b class="badge {{$badge['class']}} pos-abt pull-bottom">{{$badge['data']()}}</b>
                @endisset
            </i>
            <span>{{$label}}</span>
        </a>
    </li>
@endisset
