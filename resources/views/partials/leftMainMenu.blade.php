@if(isset($childs) && $childs)
    <li role="presentation"  class="nav-item @if(isset($active)) {{active($active)}} @endif" >
        <a href="#{{$slug}}" id="{{$slug}}-tab" class="nav-link" role="tab" data-toggle="tab">
            <i class="{{$icon}}">
                @if(isset($badge))
                    <b class="badge {{$badge['class']}} pos-abt pull-bottom">{{$badge['data']()}}</b>
                @endif
            </i>
            <span>{{$label}}</span>
        </a>
    </li>
@else
    <li class="dropdown-item @if(isset($active)) {{active($active)}} @endif">
        <a href="{{$route}}">
            <i class="{{$icon}}">
                @if(isset($badge))
                    <b class="badge {{$badge['class']}} pos-abt pull-bottom">{{$badge['data']()}}</b>
                @endif
            </i>
            <span>{{$label}}</span>
        </a>
    </li>
@endif
