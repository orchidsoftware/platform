@isset($title)
        <div class="hidden-folded padder m-t-xs m-b-xs text-muted text-xs m-l">{{ __($title) }}</div>
@endisset
<a href="{{$route ?? '#'}}" class="dropdown-item">
    @isset($badge)
        <span class="float-right">
            <b class="badge {{$badge['class']}}">{{$badge['data']()}}</b>
        </span>
    @endisset
    <i class="{{$icon}} m-r-xs"></i>
    {{ __($label) }}
</a>