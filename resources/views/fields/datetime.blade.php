@component($typeForm,get_defined_vars())
        <div data-controller="fields--datetime" class="input-group" @include('platform::partials.fields.attributes', ['attributes' => $dataAttributes])>
            <input type="text" placeholder="Select Date.." @include('platform::partials.fields.attributes', ['attributes' => $attributes]) autocomplete="off">
            @if(true === $allowEmpty)
                <div class="input-group-append bg-white border-left-0">
                    <a class="input-group-text bg-transparent" title="clear" data-action="click->fields--datetime#clear">
                        <i class="icon-cross"></i>
                    </a>
                </div>
            @endif
        </div>
@endcomponent
