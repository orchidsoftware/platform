<tr>
    @foreach($columns as $column)

        <th class="p-0 align-middle">
            {!!
               $fields[$column]
                    ->value($row[$column] ?? '')
                    ->prefix($name)
                    ->id("$column-$key-$column")
                    ->name($keyValue ? $column : "[$key][$column]")
            !!}
        </th>

        @if ($loop->last)
            <th class="no-border text-center align-middle">
                <a href="#"
                   data-action="fields--matrix#deleteRow"
                   class="text-xs text-muted"
                   title="Remove row">
                    <x-orchid-icon path="trash"/>
                </a>
            </th>
        @endif
    @endforeach
</tr>
