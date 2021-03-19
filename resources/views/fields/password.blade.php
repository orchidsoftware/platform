@component($typeForm, get_defined_vars())

    <div data-controller="password"
         class="input-icon"
    >
        <input {{ $attributes }} data-target="password.password">
        <div class="input-icon-addon cursor" data-action="click->password#change">

            <span data-target="password.iconShow">
                <x-orchid-icon path="eye" class="small me-2"/>
            </span>

            <span data-target="password.iconLock" class="none">
                <x-orchid-icon path="lock" class="small me-2"/>
            </span>
        </div>
    </div>

@endcomponent
