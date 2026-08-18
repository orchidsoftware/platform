@isset($title)
    <li class="nav-item mt-3 mb-1" role="presentation">
        <small class="text-muted ms-4 w-100 user-select-none">{{ __($title) }}</small>
    </li>
@endisset

@if (!empty($name))
    @php
        $activeClass = (string) active($active);
        $hasChildren = collect($list)->isNotEmpty();
    @endphp

    <li @class(['nav-item', $activeClass, 'flex-wrap' => $hasChildren])>
        <a data-turbo="{{ var_export($turbo) }}"
            @if (!$hasChildren && $activeClass !== '') aria-current="page" @endif
            {{ $attributes->merge(['class' => $activeClass]) }}
        >
            @isset($icon)
                <x-orchid-icon :path="$icon"
                               :id="null"
                               :role="null"
                               aria-hidden="true"
                               focusable="false"
                               class="overflow-visible flex-shrink-0"/>
            @endisset

            <span class="text-break">{{ $name ?? '' }}</span>

            @isset($badge)
                <b class="badge rounded-pill bg-{{$badge['class']}} col-auto ms-auto">{{$badge['data']()}}</b>
            @endisset

            @if(($disclosure ?? false) && $hasChildren)
                <x-orchid-icon path="bs.chevron-down"
                               :id="null"
                               :role="null"
                               class="ms-auto flex-shrink-0"
                               aria-hidden="true"
                               focusable="false"/>
            @endif
        </a>

        @if($hasChildren)
            <div class="gap-3 collapse sub-menu flex-shrink-0 {{ active($active, 'show') }}"
                 id="menu-{{$slug}}"
                 @isset($parent)
                    data-bs-parent="#menu-{{$parent}}"
                 @else
                    data-bs-parent="#headerMenuCollapse"
                 @endisset
            >
                <div class="vr ms-3 my-2" aria-hidden="true"></div>
                <ul class="nav nav-pills gap-1 d-flex flex-column flex-nowrap flex-grow-1 ps-0">
                    @foreach($list as $item)
                        {!! $item->build($source) !!}
                    @endforeach
                </ul>
            </div>
        @endif
    </li>
@endif

@if($divider)
    @if($visibleDivider ?? false)
        <li class="divider my-2 border-bottom" role="separator"></li>
    @else
        <li class="divider my-2"></li>
    @endif
@endif
