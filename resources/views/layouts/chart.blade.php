<div data-controller="chart" data-chart-config-value="{{ json_encode($chart) }}">
    <div class="chart-card bg-white rounded shadow-sm mb-3">

        <div class="d-flex mb-3 align-items-center">
            <legend class="text-body-emphasis mb-0">
                <div class="d-flex align-items-center">
                    <small class="d-block">{{ __($title ?? '') }}</small>

                    @if($export)
                        <a href="#" class="ms-auto px-2 text-muted" data-action="chart#export" title="{{ __('Export') }}">
                            <x-orchid-icon path="bs.cloud-arrow-down"/>
                        </a>
                    @endif
                </div>

                @empty(!$description)
                    <p class="small text-muted mb-0 content-read text-balance">
                        {!! __($description  ?? '') !!}
                    </p>
                @endempty
            </legend>

        </div>

        <div class="position-relative w-100">
            <figure data-chart-target="canvas" class="chart-card__canvas w-100 my-0 p-0"
                    style="min-height: {{ $height }}px"></figure>
        </div>
    </div>
</div>
