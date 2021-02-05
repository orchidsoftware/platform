<div class="avatar-group d-flex">
    @foreach($users as $user)
        <a href="{{ $user->url() }}" class="avatar thumb-xs"
           data-controller="tooltip"
           data-action="mouseover->tooltip#mouseOver"
           data-toggle="tooltip"
           data-placement="top"
           title="{{ $user->title() }}">
            <img src="{{ $user->image() }}"
                 class="avatar-img rounded-circle b bg-light"
                 alt="{{ $user->title() }}">
        </a>
    @endforeach
</div>

