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

    .avatar {
        transition: all 340ms;
    }

    /*
    .avatar-group .avatar:hover {
        -webkit-mask-image: none;
        mask-image: none;
        z-index: 1;
    }
     */
    .avatar-title {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background-color: #f5f8fa;
    }
</style>


<script>
    window.addEventListener("load", function () {
        $('.avatar.thumb-xs').tooltip('toggleEnabled');
    });
</script>
