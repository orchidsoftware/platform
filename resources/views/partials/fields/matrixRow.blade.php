<tr>
    @foreach($columns as $column)
        <th class="p-0">
                        <textarea class="form-control border-0 no-resize"
                                  rows="auto"
                                  @if($keyValue)
                                    name="{{$name}}[{{ $column }}]"
                                  @else
                                    name="{{$name}}[{{  $key ?? 0 }}][{{ $column }}]"
                                  @endif
                        >{{ $row[$column] ?? '' }}</textarea>
        </th>

        @if ($loop->last)
            <th class="no-border text-center align-middle">
                <a href="#"
                   data-action="fields--matrix#deleteRow"
                   class="text-xs text-muted"
                   title="Remove row">
                    <i class="icon-trash"></i>
                </a>
            </th>
        @endif
    @endforeach
</tr>
