<a href="{{$route ?? '#'}}" class="dropdown-item">
    @isset($badge)
        <span class="float-right">
            <b class="badge {{$badge['class']}}">{{$badge['data']()}}</b>
        </span>
    @endisset
    <i class="{{$icon}} m-r-xs"></i>
    {{ __($label) }}
</a>