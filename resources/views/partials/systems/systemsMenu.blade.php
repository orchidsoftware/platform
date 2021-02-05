@empty(!$children->count())
    <div class="admin-element w-100 {{$class ?? ''}}">
        <h3 class="fw-light h3 text-black">
            @isset($icon)
                <x-orchid-icon :path="$icon" class="me-2"/>
            @endisset

            {{ __($label)}}
        </h3>
        <div class="line line-dashed border-bottom my-3"></div>
        <ul class="list-group no-borders">

            @foreach ($children as $item)
                @include('platform::partials.systems.systemsSubMenu', $item)
            @endforeach

        </ul>
    </div>
@endempty
