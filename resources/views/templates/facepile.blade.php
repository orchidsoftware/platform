
<div class="avatar-group d-flex justify-content-start">
    @foreach($users as $user)
        <a href="{{ $user->url() }}" class="avatar thumb-xs"
           data-controller="layouts--tooltip"
           data-action="mouseover->layouts--tooltip#mouseOver"
           data-toggle="tooltip"
           data-placement="top"
           title="{{ $user->title() }}">
            <img src="{{ $user->image() }}"
                 class="avatar-img rounded-circle b bg-light"
                 alt="{{ $user->title() }}">
        </a>
    @endforeach
</div>


<style>
    .avatar-group .thumb-xs + .thumb-xs {
        margin-left: -.40625rem;
    }
</style>

