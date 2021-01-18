<div
     data-controller="screen--chart"
     data-screen--chart-parent="#{{$slug}}"
     data-screen--chart-title="{{$title}}"
     data-screen--chart-labels="{{$labels}}"
     data-screen--chart-datasets="{{$data}}"
     data-screen--chart-type="{{$type}}"
     data-screen--chart-height="{{$height}}"
     data-screen--chart-colors="{{$colors}}"
     data-screen--chart-max-slices="{{$maxSlices}}"
     data-screen--chart-values-over-points="{{$valuesOverPoints}}"
     data-screen--chart-axis-options="{{$axisOptions}}"
     data-screen--chart-bar-options="{{$barOptions}}"
     data-screen--chart-line-options="{{$lineOptions}}"
     data-screen--chart-markers="{{$markers}}"
>
    <div class="bg-white rounded shadow-sm mb-3 pt-3">
        <div class="position-relative w-100">
            @if($export)
                <div class="top-right pt-1 pr-4" style="z-index: 1">
                    <button class="btn btn-sm btn-link"
                            data-action="screen--chart#export">
                        {{ __('Export') }}
                    </button>
                </div>
            @endif
            <figure id="{{$slug}}" class="w-100 h-full"></figure>
        </div>
    </div>
</div>
