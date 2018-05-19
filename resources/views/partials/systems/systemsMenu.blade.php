<div class="col-md-5 col-md-4">

    <div class="admin-element w-full">
        <h3 class="font-thin h3 text-black">
            <i class="{{$icon}}"></i>{{trans($label)}}
        </h3>
        <div class="line line-dashed b-b line-lg"></div>
        <ul class="list-group no-bg no-borders pull-in auto m-l-lg">

            {!! Dashboard::menu()->render($slug,'platform::partials.systems.systemsSubMenu') !!}

        </ul>
    </div>

</div>
