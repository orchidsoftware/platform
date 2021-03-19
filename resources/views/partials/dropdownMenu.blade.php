@isset($title)
    <div class="hidden-folded padder m-t-xs mb-1 text-muted small ms-3">{{ __($title) }}</div>
@endisset

<a href="{{$route ?? '#'}}" class="dropdown-item @isset($active) {{active($active)}} @endisset">

    <span class="col-auto me-auto p-0 d-flex align-items-center">
        @empty(!$icon)
            <x-orchid-icon :path="$icon" class="me-2"/>
        @endisset
        {{ __($label) }}
    </span>

    @isset($badge)
        <span class="col-auto p-0">
                <b class="badge badge-{{$badge['class']}}">{{$badge['data']()}}</b>
        </span>
    @endisset
</a>
