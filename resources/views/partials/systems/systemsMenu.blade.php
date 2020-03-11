@empty(!$children->count())
    <div class="admin-element w-full {{$class ?? ''}}">
        <h3 class="font-thin h3 text-black">
            <i> {!! \Orchid\Support\Facades\Dashboard::icon($icon) !!}</i>{{ __($label)}}
        </h3>
        <div class="line line-dashed b-b line-lg"></div>
        <ul class="list-group no-bg no-borders pull-in auto">

            @foreach ($children as $item)
                @include('platform::partials.systems.systemsSubMenu', $item)
            @endforeach

        </ul>
    </div>
@endempty
