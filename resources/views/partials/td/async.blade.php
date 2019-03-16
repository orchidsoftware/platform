<a href="#"
   data-action="screen--base#targetModal"
   data-modal-title="{{ $title ?? '' }}"
   data-modal-async="true"
   data-modal-key="{{$modal ?? ''}}"
   data-modal-params="@json($attributes)"
   data-modal-action="{{route($route ?? Route::currentRouteName(),$attributes)}}/{{$method}}"
>
    {!! $text !!}
</a>
