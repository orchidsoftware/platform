<li class="list-group-item admin-element-item {{$class ?? ''}}">
    <a href="{{$route}}" class="d-block">
        @isset($badge)
            <b class="badge bg-{{$badge['class']}} pull-right">{{$badge['data']()}}</b>
        @endisset
        <span class="text-muted">
            @isset($icon)
                <x-orchid-icon :path="$icon" class="pull-right m-t-sm h5"/>
            @endisset
        </span>
        <div class="clear">
            <div>{{ __($label) }}</div>
            <small class="text-muted">{{ __($title ?? '') }}</small>
        </div>
    </a>
</li>
