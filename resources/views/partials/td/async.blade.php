<a href="#"
   data-action="screens--base#targetAsyncModal"
   data-modal-title="Асинхронная модалочка"
   data-modal-key="{{$modal or ''}}"
   data-modal-action="{{route(Route::currentRouteName(),$attributes)}}/async"
>
    {{$text}}
</a>
