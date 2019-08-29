@component($typeForm,get_defined_vars())

    <table class="table table-bordered">
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
            <tr>
                @foreach($columns as $column)
                    <th class="p-0">
                        <textarea class="form-control border-0"
                               style="border-radius: 0;resize: none"
                               name="{{$name}}[{{$key}}][$column]"
                        >{{ $row[$column] }}</textarea>
                    </th>

                    @if ($loop->last)
                        <th class="p-0 v-center h-100">
                            <i class="icon-trash"></i>
                        </th>
                    @endif

                @endforeach
            </tr>

            @if ($loop->last)
                <tr>
                    <th colspan="{{ count($columns) + 1 }}" class="text-center">
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
