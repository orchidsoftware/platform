<div data-controller="matrix"
     data-matrix-index="{{ $index }}"
     data-matrix-rows="{{ $maxRows }}"
     data-matrix-key-value="{{ var_export($keyValue) }}"
>
    <div class="table-responsive">
        <table class="matrix table table-bordered">
            <thead>
            <tr>
                @foreach($columns as $key => $column)
                    <th scope="col" class="text-capitalize">
                        {{ is_int($key) ? $column : $key }}
                    </th>
                @endforeach
                @if($removableRows)
                    <th scope="col"></th>
                @endif
            </tr>
            </thead>
            <tbody>
            @foreach($value as $key => $row)
                @include('orchid::partials.fields.matrixRow', ['row' => $row, 'key' => $key])
            @endforeach
            <tr class="add-row">
                <th colspan="{{ count($columns) + ($removableRows ? 1 : 0) }}" class="text-center p-0">
                    <button type="button" data-action="matrix#addRow" class="btn btn-link btn-sm text-muted">
                        <x-orchid-icon path="bs.plus-circle" class="me-2"/>
                        <span>{{ __($addRowLabel) }}</span>
                    </button>
                </th>
            </tr>
            </tbody>
        </table>
    </div>
    <template class="matrix-template">
        @include('orchid::partials.fields.matrixRow', ['row' => [], 'key' => '{index}'])
    </template>
</div>
