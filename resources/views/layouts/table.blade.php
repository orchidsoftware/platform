@empty(!$title)
    <fieldset>
            <div class="col p-0 px-3">
                <legend class="text-body-emphasis mt-2 mx-2">
                    {{ $title }}
                </legend>
            </div>
    </fieldset>
@endempty

<div class="bg-white rounded shadow-sm mb-3 overflow-hidden"
     data-controller="table"
     data-table-slug="{{$slug}}"
>

    <div class="table-responsive">
        <table @class([
                    'table',
                    'table-compact'  => $compact,
                    'table-striped'  => $striped,
                    'table-bordered' => $bordered,
                    'table-hover'    => $hoverable,
               ])>

            @if($showHeader)
                <thead>
                    <tr>
                        @if($detail !== null)
                            <th class="text-center" width="1"></th>
                        @endif
                        @foreach($columns as $column)
                            {!! $column->buildTh() !!}
                        @endforeach
                    </tr>
                </thead>
            @endif

            <tbody>

            @foreach($rows as $source)
                @php
                    $rowLoop = $loop;
                    $detailTarget = "row-detail-{$slug}-{$loop->index}";
                    $detailPayload = $detail?->deferredPayload($slug, $detailTarget, $source, $rowLoop) ?? [];
                    $detailOpen = $detail?->isOpenByDefault() ?? false;
                    $detailDeferred = $detail?->isDeferred() ?? false;
                @endphp
                <tr>
                    @if($detail !== null)
                        <td class="text-center align-middle" width="1">
                            <button type="button"
                                    class="btn btn-link icon-link p-0"
                                    title="{{ $detail->buttonLabelValue() }}"
                                    aria-label="{{ $detail->buttonLabelValue() }}"
                                    aria-controls="{{ $detailTarget }}"
                                    aria-expanded="{{ var_export($detailOpen) }}"
                                    data-action="table#toggleDetail"
                                    data-detail-target-id="{{ $detailTarget }}"
                                    data-detail-url="{{ route('orchid.async.row-detail') }}"
                                    data-detail-body='@json($detailPayload['body'] ?? [])'
                                    data-detail-query='@json($detailPayload['query'] ?? [])'
                                    data-detail-loaded="{{ var_export(!$detailDeferred) }}"
                            >
                                <x-orchid-icon :path="$detail->iconValue()" class="overflow-visible"/>
                            </button>
                        </td>
                    @endif
                    @foreach($columns as $column)
                        {!! $column->buildTd($source, $rowLoop) !!}
                    @endforeach
                </tr>
                @if($detail !== null)
                    <tr data-row-detail-row
                        @class(['d-none' => !$detailOpen])
                    >
                        <td colspan="{{ $columns->count() + 1 }}" class="p-0 border-top-0">
                            <div id="{{ $detailTarget }}" class="px-4 py-3 bg-light">
                                @if($detailDeferred)
                                    <div class="text-muted small">{{ __('Loading...') }}</div>
                                @else
                                    {!! $detail->build($source, $rowLoop, $repository) !!}
                                @endif
                            </div>
                        </td>
                    </tr>
                @endif
            @endforeach

            @if($total->isNotEmpty() && $rows->isNotEmpty())
                <tr>
                    @if($detail !== null)
                        <td></td>
                    @endif
                    @foreach($total as $column)
                        {!! $column->buildTd($repository, $loop) !!}
                    @endforeach
                </tr>
            @endif

            </tbody>
        </table>
    </div>

    @if($rows->isEmpty())
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
    @else

        @include('orchid::layouts.pagination',[
                'paginator' => $rows,
                'columns' => $columns,
                'onEachSide' => $onEachSide,
        ])

    @endif
</div>


