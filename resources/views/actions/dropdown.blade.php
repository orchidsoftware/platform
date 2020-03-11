@component($typeForm, get_defined_vars())
    <button
        @attributes($attributes)
        data-toggle="dropdown"
        aria-expanded="false"
    >
        {!! \Orchid\Support\Facades\Dashboard::icon( $icon ?? '') !!}


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
