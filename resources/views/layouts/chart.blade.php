<div
     data-controller="screen--chart"
     data-screen--chart-parent="#{{$slug}}"
     data-screen--chart-title="{{$title}}"
     data-screen--chart-labels="{{$labels}}"
     data-screen--chart-datasets="{{$data}}"
     data-screen--chart-type="{{$type}}"
     data-screen--chart-height="{{$height}}"
     data-screen--chart-colors="{{$colors}}"
>
    <div class="row py-3">
        <div class="pos-rlt w-full">
            <div class="top-right pt-1 pr-4" style="z-index: 1">
                <button class="btn btn-sm btn-link"
                        data-action="screen--chart#export">
                    {{ __('Export') }}
                </button>
            </div>

            <figure id="{{$slug}}" class="w-full h-full"></figure>
        </div>
    </div>
</div>
