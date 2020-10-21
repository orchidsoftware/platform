@component($typeForm, get_defined_vars())
    <button
        {{ $attributes }}
        data-toggle="dropdown"
        aria-expanded="false"
    >
        @isset($icon)
            <x-orchid-icon :path="$icon" class="{{ empty($name) ?: 'mr-2'}}"/>
        @endisset

        {{ $name ?? '' }}
    </button>

    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow bg-white"
         x-placement="bottom-end"
    >
        @foreach($list as $item)
            {!!  $item->build($source) !!}
        @endforeach
    </div>
@endcomponent
