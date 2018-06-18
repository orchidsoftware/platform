<tr>
    <td class="text-left">
        <button type="button" class="btn btn-sm btn-link" data-action="components--boot#removeColumn">
            <i class="icon-trash m-r-xs"></i> {{$relation['name'] ?? '{%=o.field%}'}}
        </button>
        <input type="hidden" value="{{$relation['name'] ?? '{%=o.field%}'}}" name="relations[{{$relation['name'] ?? '{%=o.field%}'}}][name]">
    </td>
    <td class="text-center">
        <select name="relations[{{$relation['name'] ?? '{%=o.field%}'}}][type]" class="form-control">
            @foreach ($relationTypes as $key => $relationType)
                <option
                        value="{{$key}}"
                        @isset($relation['type'])
                            @if($relation['type'] == $key)
                                selected
                            @endif
                        @endisset
                >
                    {{$relationType}}
                </option>
            @endforeach
        </select>
    </td>
    <td class="text-center">
        <select name="relations[{{$relation['name'] ?? '{%=o.field%}'}}][local]" class="form-control">
            <option value="">Don't Use</option>
            @foreach($columns as $column)
                <option
                        value="{{$column['name']}}"
                        @isset($relation['local'])
                            @if($relation['local'] == $column['name'])
                                selected
                            @endif
                        @endisset
                >
                    {{$column['name']}}
                </option>
            @endforeach
        </select>
    </td>
    <td class="text-center">
        <select name="relations[{{$relation['name'] ?? '{%=o.field%}'}}][related]" class="form-control">
                @include('platform::partials.boot.relatedOption',[
                    'models' => $models,
                    'name' => $relation['name'] ?? '',
                    'related' => $relation['related'] ?? ''
                ])
        </select>
    </td>
</tr>