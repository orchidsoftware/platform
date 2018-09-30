@if(!empty($group))
    <a href="#" class="btn btn-link dropdown-item m-l-sm no-padder" data-toggle="dropdown" aria-expanded="false">
        <i class="{{$icon ?? ''}} m-r-xs"></i>{{$name ?? ''}}
    </a>
    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow bg-white" x-placement="bottom-end">
        @foreach($group as $item)
            @includeWhen($item->show,'platform::container.layouts.link',[
                'slug'      => $item->slug,
                'name'      => $item->name,
                'method'    => $item->method,
                'icon'      => $item->icon,
                'modal'     => $item->modal,
                'title'     => $item->title,
                'link'      => $item->link,
                'group'     => $item->group,
                'arguments' => $arguments,
            ])
        @endforeach
    </div>
@elseif(!is_null($modal))
    <button type="button"
            class="btn btn-link dropdown-item m-l-sm no-padder"
            data-action="screen--base#targetModal"
            data-modal-title="{{$title ?? ''}}"
            data-modal-key="{{$modal ?? ''}}"
            data-modal-action="{{route(Route::currentRouteName(),$arguments)}}/{{$method}}"
    >
        <i class="{{$icon ?? ''}} m-r-xs"></i>{{$name ?? ''}}
    </button>
@elseif(!is_null($method))

    <button type="submit"
            formaction="{{route(Route::currentRouteName(),$arguments)}}/{{$method}}"
            form="post-form"
            class="btn btn-link dropdown-item m-l-sm no-padder">
        @isset($icon)<i class="{{$icon}} m-r-xs"></i>@endisset
        {{$name ?? ''}}
    </button>
@else

    <a href="{{$link ?? ''}}" class="btn btn-link dropdown-item m-l-sm no-padder">
        <i class="{{$icon ?? ''}} m-r-xs"></i>{{$name ?? ''}}
    </a>
@endif
