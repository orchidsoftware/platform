<div data-controller="chart"
     data-action="load@window->chart#render"
     data-chart-type-value="{{ $chart['type'] }}"
     data-chart-labels-value="{{ json_encode($chart['data']['labels']) }}"
     data-chart-datasets-value="{{ json_encode($chart['data']['datasets']) }}"
     data-chart-markers-value="{{ json_encode($chart['data']['markers'] ?? []) }}"
     data-chart-regions-value="{{ json_encode($chart['data']['regions'] ?? []) }}"
     @foreach($chart['options'] as $option => $value)
         @if($option === 'gradient' && is_array($value))
             data-chart-gradient-value="true"
             @foreach($value as $endpoint => $opacity)
                 data-chart-gradient-{{ \Illuminate\Support\Str::kebab($endpoint) }}-value="{{ $opacity }}"
             @endforeach
         @else
             data-chart-{{ \Illuminate\Support\Str::kebab($option) }}-value="{{ json_encode($value) }}"
         @endif
     @endforeach
>
    <div class="bg-white rounded shadow-sm mb-3 pt-3">

        <div class="d-flex px-3 align-items-center">
            <legend class="text-body-emphasis px-2 mt-2 mb-0">
                <div class="d-flex align-items-center">
                    <small class="d-block">{{ __($title ?? '') }}</small>

                    @if($export)
                        <a href="#" class="ms-auto px-2 text-muted" data-action="chart#export:prevent" title="{{ __('Export') }}">
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

        <div class="position-relative w-100 px-4 pt-3 pb-4">
            <figure data-chart-target="canvas" class="w-100 h-full m-0 p-0 d-flex"
                    style="min-height: {{ $height }}px"></figure>
        </div>
    </div>
</div>
