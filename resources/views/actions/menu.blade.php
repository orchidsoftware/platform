@isset($title)
    <li class="nav-item mt-3 mb-1">
        <small class="text-muted ms-4 w-100 user-select-none">{{ __($title) }}</small>
    </li>
@endisset

@if (!empty($name))
<li class="nav-item {{ active($active) }}">
    <a data-turbo="{{ var_export($turbo) }}"
        {{ $attributes }}
    >
        @isset($icon)
            <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'me-2'}}"/>
        @endisset

        <span class="me-2">{{ $name ?? '' }}</span>

        @isset($badge)
            <b class="badge bg-{{$badge['class']}} col-auto ms-auto">{{$badge['data']()}}</b>
        @endisset
    </a>
</li>
@endif

@if(!empty($list))
    <div class="nav collapse sub-menu ps-2 {{active($active, 'show')}}"
         id="menu-{{$slug}}"
         @isset($parent)
            data-bs-parent="#menu-{{$parent}}">
         @else
            data-bs-parent="#headerMenuCollapse">
         @endisset
        @foreach($list as $item)
            {!!  $item->build($source) !!}
        @endforeach
    </div>
@endif

@if($divider)
    <li class="divider my-2"></li>
@endif

