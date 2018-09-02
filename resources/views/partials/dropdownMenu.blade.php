<a href="{{$route ?? '#'}}" class="dropdown-item">
    @isset($badge)
        <b class="badge {{$badge['class']}} pull-right">{{$badge['data']()}}</b>
    @endisset
    <i class="{{$icon}} m-r-xs"></i>
    <span>{{trans($label)}}</span>
</a>