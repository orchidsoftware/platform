@component($typeForm, get_defined_vars())
    <div data-controller="fields--datetime"
         class="input-group"
        @attributes($dataAttributes)>
        <input type="text"
               placeholder="{{$placeholder ?? ''}}"
               @attributes($attributes)
               autocomplete="off"
               data-target="fields--datetime.instance"
        >

        @if(true === $allowEmpty)
            <div class="input-group-append bg-white">
                <a class="input-group-text bg-transparent"
                   title="clear"
                   data-action="click->fields--datetime#clear">
                        <i class="icon-cross"></i>
                    </a>
                </div>
            @endif
        </div>
@endcomponent




