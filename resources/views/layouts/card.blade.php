<div class="padder-v d-block">
    <div class="card">
        <div class="row no-gutters">

            @empty(!$image)
                <div class="col-md-3">
                    <div class="h-100" style="display: contents">
                        <img src="{{ $image }}" class="img-fluid img-card">
                    </div>
                </div>
            @endempty

            <div class="col">
                <div class="card-body h-full d-table">
                    <div class="row d-flex align-items-center mb-1">
                        <div class="col-auto">
                            <h5 class="card-title">
                                @empty(!$color)<i class="text-{{ $color }}">●</i>@endempty
                                {{ $title ?? '' }}
                            </h5>
                        </div>

                        @if(count($commandBar) > 0)
                            <div class="col-auto ml-auto text-right">
                                <div class="btn-group command-bar">
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
                            </div>
                        @endif
                    </div>
                    <div class="card-text">{!! $descriptions ?? '' !!}</div>
                </div>
            </div>

        </div>
    </div>
</div>
