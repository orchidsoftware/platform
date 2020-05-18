@component($typeForm, get_defined_vars())
    <table class="matrix table table-bordered border-right-0"
           data-controller="fields--matrix"
           data-fields--matrix-index="{{ count($value) }}"
           data-fields--matrix-rows="{{ $maxRows }}"
           data-fields--matrix-key-value="{{ var_export($keyValue) }}"
    >
        <thead>
        <tr>
            @foreach($columns as $key => $column)
                <th scope="col" class="text-capitalize">
                    {{ is_int($key) ? $column : $key }}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>

        @foreach($value as $key => $row)
            @include('platform::partials.fields.matrixRow',['row' => $row, 'key' => $key])
        @endforeach

        <tr class="add-row">
            <th colspan="{{ count($columns) }}" class="text-center p-0">
                <a href="#" data-action="fields--matrix#addRow" class="btn btn-block text-xs text-muted">
                    <i class="icon-plus-alt"></i>
                    <span>{{ __('Add row') }}</span>
                </a>
            </th>
        </tr>

        <template>
            @include('platform::partials.fields.matrixRow',['row' => [], 'key' => '{index}'])
        </template>
        </tbody>
    </table>
@endcomponent
