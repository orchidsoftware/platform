<div data-controller="password"
     class="input-icon"
>
    <input {{ $attributes }} data-password-target="password">
    <div class="input-icon-addon cursor" data-action="click->password#change">

        <span data-password-target="iconShow">
            <x-orchid-icon path="bs.eye" class="small me-2"/>
        </span>

        <span data-password-target="iconLock" class="none">
            <x-orchid-icon path="bs.eye-slash" class="small me-2"/>
        </span>
    </div>
</div>
