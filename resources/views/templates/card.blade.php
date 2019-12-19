<div class="padder-v d-block">
    <div class="card">
        <div class="row no-gutters">

            @empty(!$image)
                <div class="col-md-3">
                    <div class="h-100" style="display: contents">
                        <img src="{{ $image }}" class="img-fluid" style="
                            object-fit: cover;
                            width: 100%;
                            height: 100%;
                        ">
                    </div>
                </div>
            @endempty

            <div class="col">
                <div class="card-body h-full d-table">

                    <div class="row d-flex align-items-center mb-1">
                        <div class="col-auto">
                            <h5 class="card-title">
                                <i class="text-success">●</i> {{ $title }}
                            </h5>
                        </div>

                        <div class="col-auto ml-auto text-right">
                            @if(count($commandBar) > 0)
                                <div class="btn-group command-bar" style="position: initial">
                                    <button class="btn btn-link btn-sm dropdown-toggle dropdown-item p-2" type="button"
                                            data-toggle="dropdown"
                                            aria-haspopup="true" aria-expanded="false">
                                        <i class="icon-options-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow bg-white"
                                         x-placement="bottom-end">
                                        @foreach ($commandBar as $command)
                                            {!! $command !!}
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-text">{!! $descriptions  !!}</div>
                </div>
            </div>


        </div>
    </div>
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

{{--
<div class="card w-full b-n border-0 padder-v">
    <div class="card-body no-padder">
        <div class="row">
            <div class="col-sm-12">
                <div class="d-flex align-items-center">
                    <span class="float-left mr-4"><img
                            src="https://www.gravatar.com/avatar/16a0f7555b060a960db3506028e6df3d" alt=""
                            class="rounded-circle img-thumbnail"></span>
                    <div>

                        <h3 class="mt-1 font-thin mb-2 text-black">Michael Franklin
                            <small class="text-muted">(Authorised Brand Seller)</small>
                        </h3>

                        <div class="my-3">
                            <span class="mr-2">
                                <strong class="text-black">561</strong>
                                <span class="text-muted">Posts</span>
                            </span>
                            <span class="mr-2">
                                <strong class="text-black">4,000</strong>
                                <span class="text-muted">Followers</span>
                            </span>
                            <span class="mr-2">
                                <strong class="text-black">500</strong>
                                <span class="text-muted">Following</span>
                            </span>
                        </div>

                        <ul class="mb-0 list-inline b-t pt-2 d-none">

                            <li class="list-inline-item pr-4 b-r">
                                <h5 class="mb-0 text-black font-thin">$ 25,184</h5>
                                <small class="text-muted block mb-1">Sales Today</small>
                            </li>
                            <li class="list-inline-item pr-4 b-r">
                                <h5 class="mb-0 text-black font-thin">$ 25,184</h5>
                                <small class="text-muted block mb-1">Sales Today</small>
                            </li>
                            <li class="list-inline-item pr-4 b-r">
                                <h5 class="mb-0 text-black font-thin">$ 25,184</h5>
                                <small class="text-muted block mb-1">Sales Today</small>
                            </li>
                            <li class="list-inline-item pr-4 b-r">
                                <h5 class="mb-0 text-black font-thin">$ 25,184</h5>
                                <small class="text-muted block mb-1">Sales Today</small>
                            </li>
                            <li class="list-inline-item">
                                <h5 class="mb-0 text-black font-thin">5482</h5>
                                <small class="text-muted block mb-1">Sales Today</small>
                            </li>
                        </ul>
                    </div> <!-- end media-body-->
                </div>
            </div> <!-- end col-->

            <!-- end col-->
        </div> <!-- end row -->

    </div> <!-- end card-body/ profile-user-box-->
</div>
--}}
