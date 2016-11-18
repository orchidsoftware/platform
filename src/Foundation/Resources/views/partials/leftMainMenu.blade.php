@if(isset($childs) && $childs)


    <li role="presentation">
        <a href="#{{$slug}}" id="{{$slug}}-tab" role="tab" data-toggle="tab">
            <i class="{{$icon}}"></i>
            <span>{{$label}}</span>
        </a>
    </li>

@else

    <li>
        <a href="{{$route}}">
            <i class="{{$icon}}"></i>
            <span>{{$label}}</span>
        </a>
    </li>

@endif