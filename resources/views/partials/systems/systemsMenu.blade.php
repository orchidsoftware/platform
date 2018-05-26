<div class="admin-element w-full">
    <h3 class="font-thin h3 text-black">
        <i class="{{$icon}}"></i>{{trans($label)}}
    </h3>
    <div class="line line-dashed b-b line-lg"></div>
    <ul class="list-group no-bg no-borders pull-in auto m-l-lg">

        @foreach ($children as $item)
            @include('platform::partials.systems.systemsSubMenu', [
                'icon' => $item['icon'],
                'route' => $item['route'],
                'label' => $item['label'],
                'groupname' => $item['groupname'],
            ])
        @endforeach

    </ul>
</div>
