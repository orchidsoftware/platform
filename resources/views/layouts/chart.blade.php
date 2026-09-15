@php
    $chartId = 'chart-'.\Illuminate\Support\Str::uuid();
@endphp

<figure class="chart-card"
        style="--chart-height: {{ (int) $chart['height'] }}px"
        data-controller="chart"
        data-chart-type="{{ $chart['type'] }}"
        data-chart-config-value="{{ json_encode($chart) }}"
        @if(!empty($title)) aria-labelledby="{{ $chartId }}-title" @endif
        @if(!empty($description)) aria-describedby="{{ $chartId }}-description" @endif>
    @if(!empty($title) || !empty($description) || $export)
        <figcaption class="chart-card__header">
            <div class="chart-card__heading">
                @if(!empty($title))
                    <h2 class="chart-card__title" id="{{ $chartId }}-title">{{ __($title) }}</h2>
                @endif

                @if(!empty($description))
                    <div class="chart-card__description" id="{{ $chartId }}-description">
                        {!! __($description) !!}
                    </div>
                @endif
            </div>

            @if($export)
                <button type="button" class="chart-card__export"
                        data-action="chart#export"
                        aria-label="{{ __('Export') }}" title="{{ __('Export') }}">
                    <x-orchid-icon path="bs.cloud-arrow-down" aria-hidden="true"/>
                </button>
            @endif
        </figcaption>
    @endif

    <div class="chart-card__body">
        <div class="chart-card__canvas" data-chart-target="canvas"></div>
    </div>
</figure>
