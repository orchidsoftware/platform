@component($typeForm, get_defined_vars())

    <div data-controller="fields--password"
         class="input-icon"
    >
        <input {{ $attributes }} data-target="fields--password.password">
        <div class="input-icon-addon cursor" data-action="click->fields--password#change">

            <span data-target="fields--password.iconShow">
                <x-orchid-icon path="eye" class="text-xs mr-2"/>
            </span>

            <span data-target="fields--password.iconLock" class="none">
                <x-orchid-icon path="lock" class="text-xs mr-2"/>
            </span>
        </div>
    </div>

@endcomponent
