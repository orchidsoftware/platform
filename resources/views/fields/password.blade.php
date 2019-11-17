@component($typeForm, get_defined_vars())

    <div    data-controller="fields--password"
            class="input-icon"
    >
        <input @attributes($attributes) data-target="fields--password.password">
        <div class="input-icon-addon cursor" data-action="click->fields--password#change">
            <i class="icon-eye" data-target="fields--password.icon"></i>
        </div>
    </div>

@endcomponent
