@isset($childs)
    <div class="tab-pane fade in nav @isset($active) show {{active($active)}} @endisset" role="tabpanel" id="{{$slug}}"
         aria-labelledby="{{$slug}}-tab">
        {!! Dashboard::menu()->render($slug,'platform::partials.leftMenu') !!}
    </div>
@endisset
