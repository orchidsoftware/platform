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
                <li
                    data-model-id="{{ $model->getKey() }}"
                    class="list-group-item d-flex justify-content-between align-items-center px-4 py-3">
                    <button
                        type="button"
                        class="reorder-handle btn btn-link p-2 me-3 flex-shrink-0 cursor-move"
                        data-action="keydown.up->sortable#moveUp keydown.down->sortable#moveDown"
                        aria-label="{{ __('Reorder') }}"
                        title="{{ __('Drag to reorder. Use arrow keys for precise movement.') }}"
                    >
                        <x-orchid-icon path="bs.arrow-down-up"/>
                    </button>

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
