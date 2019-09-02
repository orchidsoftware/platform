@component($typeForm,get_defined_vars())
    <table class="table table-bordered border-right-0">
        <colgroup>
            <col width="*">
            <col width="*">
            <col width="20px">
        </colgroup>
        <thead>
        <tr>
            @foreach($columns as $column)
                <th scope="col" class="text-capitalize">
                    {{ $column }}
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>

        @foreach($value as $key => $row)
            <tr class="key-rows-{{ $key }}">
                @foreach($columns as $column)
                    <th class="p-0">
                        <textarea class="form-control border-0"
                               style="border-radius: 0;resize: none"
                               rows="auto"
                               name="{{$name}}[{{$key}}][$column]"
                        >{{ $row[$column] }}</textarea>
                    </th>

                    @if ($loop->last)
                        <th class="p-0 no-border text-center align-middle">
                            <a href="#"
                                    onclick="alert('Строка #{{$key}}')"
                                    class="text-xs text-muted"
                                    title="Remove row">
                                <i class="icon-trash"></i>
                            </a>
                        </th>
                    @endif

                @endforeach
            </tr>

            @if ($loop->last)
                <tr>
                    <th colspan="{{ count($columns) }}" class="text-center p-2">
                        <a href="#" class="text-xs text-muted">
                            <i class="icon-plus-alt"></i>
                            <span>Add row</span>
                        </a>
                    </th>
                </tr>
            @endif

        @endforeach
        </tbody>
    </table>
@endcomponent
