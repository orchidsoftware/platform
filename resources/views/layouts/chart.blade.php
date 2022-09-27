<div
     data-controller="chart"
     data-chart-parent="#{{$slug}}"
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

        <div class="d-flex px-3 align-items-center">
            <legend class="text-black px-2 mt-2 mb-0">
                <div class="d-flex align-items-center">
                    <small class="d-block">{{ __($title ?? '') }}</small>

                    @if($export)
                        <a href="#" class="ms-auto px-2 text-muted" data-action="chart#export" title="{{ __('Export') }}">
                            <x-orchid-icon path="cloud-download" height="0.9em" width="0.9em"/>
                        </a>
                    @endif
                </div>

                @empty(!$description)
                    <p class="small text-muted mt-2 mb-0 content-read">
                        {!! __($description  ?? '') !!}
                    </p>
                @endempty
            </legend>

        </div>

        <div class="position-relative w-100">
            <figure id="{{$slug}}" class="w-100 h-full m-0 p-0 d-flex"></figure>
        </div>
    </div>
</div>
