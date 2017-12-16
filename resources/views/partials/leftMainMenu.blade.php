@if(isset($childs) && $childs)
    <li role="presentation" @if(isset($active)) class="{{active($active)}}" @endif>
        <a href="#{{$slug}}" id="{{$slug}}-tab" role="tab" data-toggle="tab">
            <i class="{{$icon}}">
                @if(isset($badge))
                    <b class="label {{$badge['class']}} pos-abt pull-bottom">{{$badge['data']()}}</b>
                @endif
            </i>
            <span>{{$label}}</span>
        </a>
    </li>
@else
    <li @if(isset($active)) class="{{active($active)}}" @endif>
        <a href="{{$route}}">
            <i class="{{$icon}}">
                @if(isset($badge))
                    <b class="label {{$badge['class']}} pos-abt pull-bottom">{{$badge['data']()}}</b>
                @endif
            </i>
            <span>{{$label}}</span>
        </a>
    </li>
@endif
