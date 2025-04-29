@isset($title)
    <li class="nav-item mt-3 mb-1">
        <small class="text-muted ms-4 w-100 user-select-none">{{ __($title) }}</small>
    </li>
@endisset

@if (!empty($name))
<li class="nav-item {{ active($active) }}">
    <a data-turbo="{{ var_export($turbo) }}"
        {{ $attributes->merge(['class' => active($active)]) }}
    >
        @isset($icon)
            <x-orchid-icon :path="$icon" class="overflow-visible"/>
        @endisset

        <span class="text-break">{{ $name ?? '' }}</span>

        @isset($badge)
            <b class="badge rounded-pill bg-{{$badge['class']}} col-auto ms-auto">{{$badge['data']()}}</b>
        @endisset
    </a>
</li>
@endif

@if(!empty($list))
    <div class="gap-3 collapse sub-menu {{ active($active, 'show') }}"
         id="menu-{{$slug}}"
         @isset($parent)
            data-bs-parent="#menu-{{$parent}}">
         @else
            data-bs-parent="#headerMenuCollapse">
         @endisset

             <div class="vr ms-3"></div>
             <div class="nav nav-pills gap-1 d-flex flex-column w-100">
                  @foreach($list as $item)
                      {!!  $item->build($source) !!}
                  @endforeach
             </div>
    </div>
@endif

@if($divider)
    <li class="divider my-2"></li>
@endif

