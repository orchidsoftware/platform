<tr>
    @foreach($columns as $column)

        <td class="p-0 align-middle">
            {!!
               $fields[$column]
                    ->value($row[$column] ?? null)
                    ->prefix($name)
                    ->id("$idPrefix-$key-$column")
                    ->name($keyValue ? $column : "[$key][$column]")
            !!}
        </td>

        @if ($loop->last && $removableRows)
            <td class="text-center align-middle">
                <button type="button"
                   data-action="matrix#deleteRow"
                   class="btn btn-link btn-sm text-muted"
                   title="{{ __('Remove row') }}">
                    <x-orchid-icon path="bs.trash3"/>
                </button>
            </td>
        @endif
    @endforeach
</tr>
