@empty(!$title)
    <fieldset>
        <div class="col p-0 px-3">
            <legend class="text-body-emphasis mt-2 mx-2">
                {{ $title }}
            </legend>
        </div>
    </fieldset>
@endempty

<div class="mb-3 rounded shadow-sm overflow-hidden">
    @if($rows->isNotEmpty())
        <ol
            data-controller="sortable"
            data-sortable-selector-value=".reorder-handle"
            data-sortable-model-value="{{ get_class($rows->first()) }}"
            data-sortable-action-value="{{ route('orchid.sorting') }}"
            data-sortable-success-message-value="{{ $successSortMessage }}"
            data-sortable-failure-message-value="{{ $failureSortMessage }}"
            class="list-group">

            @foreach($rows as $model)
                @php
                    $rowLoop = $loop;
                    $detailTarget = "row-detail-{$slug}-{$loop->index}";
                    $detailPayload = $detail?->deferredPayload($slug, $detailTarget, $model, $rowLoop) ?? [];
                    $detailOpen = $detail?->isOpenByDefault() ?? false;
                    $detailDeferred = $detail?->isDeferred() ?? false;
                @endphp
                <li
                    data-model-id="{{ $model->getKey() }}"
                    class="list-group-item px-4 py-3 list-group-item-action">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-4 reorder-handle" data-model-id="{{ $model->getKey() }}">
                            <x-orchid-icon path="bs.arrow-down-up" class="cursor-move"/>
                        </div>

                        @if($detail !== null)
                            <div class="me-4">
                                <button type="button"
                                        class="btn btn-link icon-link p-0"
                                        title="{{ $detail->buttonLabelValue() }}"
                                        aria-label="{{ $detail->buttonLabelValue() }}"
                                        aria-controls="{{ $detailTarget }}"
                                        aria-expanded="{{ var_export($detailOpen) }}"
                                        data-action="sortable#toggleDetail"
                                        data-detail-target-id="{{ $detailTarget }}"
                                        data-detail-url="{{ route('orchid.async.row-detail') }}"
                                        data-detail-body='@json($detailPayload['body'] ?? [])'
                                        data-detail-query='@json($detailPayload['query'] ?? [])'
                                        data-detail-loaded="{{ var_export(!$detailDeferred) }}"
                                >
                                    <x-orchid-icon :path="$detail->iconValue()" class="overflow-visible"/>
                                </button>
                            </div>
                        @endif

                        @foreach($columns as $column)
                            <div class="{{ $loop->first ? 'me-auto' : 'ms-3' }}">
                                @if($showBlockHeaders)
                                    <div class="text-muted fw-normal">
                                        {!! $column->buildDt($model) !!}
                                    </div>
                                @endif

                                {!! $column->buildDd($model) !!}
                            </div>
                        @endforeach
                    </div>

                    @if($detail !== null)
                        <div data-row-detail-row
                             @class(['d-none' => !$detailOpen])
                        >
                            <div id="{{ $detailTarget }}" class="mt-3 pt-3 border-top">
                                @if($detailDeferred)
                                    <div class="text-muted small">{{ __('Loading...') }}</div>
                                @else
                                    {!! $detail->build($model, $rowLoop) !!}
                                @endif
                            </div>
                        </div>
                    @endif
                </li>
            @endforeach
        </ol>
    @else
        <div class="d-md-flex align-items-center px-md-0 px-2 pt-4 pb-5 w-100 text-md-start text-center">
            @isset($iconNotFound)
                <div class="col-auto mx-md-4 mb-3 mb-md-0">
                    <x-orchid-icon :path="$iconNotFound" class="block h1"/>
                </div>
            @endisset

            <div>
                <h3 class="fw-light">
                    {!!  $textNotFound !!}
                </h3>

                {!! $subNotFound !!}
            </div>
        </div>
    @endif
</div>
