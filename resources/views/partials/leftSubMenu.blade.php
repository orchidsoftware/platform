@if(isset($childs) && $childs)
    <div class="tab-pane fade in nav @if(isset($active)) show {{active($active)}} @endif" role="tabpanel" id="{{$slug}}"
         aria-labelledby="{{$slug}}-tab">
        {!! Dashboard::menu()->render($slug,'dashboard::partials.leftMenu') !!}
    </div>
@endif
