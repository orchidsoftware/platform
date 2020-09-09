@isset($title)
    <div class="hidden-folded padder m-t-xs m-b-xs text-muted text-xs m-l">{{ __($title) }}</div>
@endisset
<a href="{{$route ?? '#'}}" class="dropdown-item">

    <span class="col-auto mr-auto no-padder v-center">
        @isset($icon)
            <x-orchid-icon :path="$icon" class="mr-2"/>
        @endisset
        {{ __($label) }}
    </span>

    @isset($badge)
        <span class="col-auto no-padder">
                <b class="badge bg-{{$badge['class']}}">{{$badge['data']()}}</b>
        </span>
    @endisset
</a>
