<a href="#"
   data-action="screen--base#targetModal"
   data-modal-title="Асинхронная модалочка"
   data-modal-async="true"
   data-modal-key="{{$modal or ''}}"
   data-modal-params="@json($attributes)"
   data-modal-action="{{route($route ?? Route::currentRouteName(),$attributes)}}/{{$method}}"
>
    {{$text}}
</a>
