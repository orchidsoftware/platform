<div
     data-controller="chart"
     data-chart-parent="#{{$slug}}"
     data-chart-title="{{$title}}"
     data-chart-labels="{{$labels}}"
     data-chart-datasets="{{$data}}"
     data-chart-type="{{$type}}"
     data-chart-height="{{$height}}"
     data-chart-colors="{{$colors}}"
     data-chart-max-slices="{{$maxSlices}}"
     data-chart-values-over-points="{{$valuesOverPoints}}"
     data-chart-axis-options="{{$axisOptions}}"
     data-chart-bar-options="{{$barOptions}}"
     data-chart-line-options="{{$lineOptions}}"
     data-chart-markers="{{$markers}}"
>
    <div class="bg-white rounded shadow-sm mb-3 pt-3">
        <div class="position-relative w-100">
            @if($export)
                <div class="top-right pt-1 pe-4" style="z-index: 1">
                    <button class="btn btn-sm btn-link"
                            data-action="chart#export">
                        {{ __('Export') }}
                    </button>
                </div>
            @endif
            <figure id="{{$slug}}" class="w-100 h-full"></figure>
        </div>
    </div>
</div>
