<tr>
    <td class="text-left">
        <button type="button" class="btn btn-sm btn-link" data-action="components--boot#removeColumn">
            <i class="icon-trash m-r-xs"></i> {{$column['name'] ?? '{%=o.field%}'}}
        </button>
        <input type="hidden" value="{{$column['name'] ?? '{%=o.field%}'}}" name="columns[{{$column['name'] ?? '{%=o.field%}'}}][name]">
    </td>
    <td class="text-center">
        <select name="columns[{{$column['name'] ?? '{%=o.field%}'}}][type]" class="form-control" required>
                @foreach($fieldTypes as $key => $type)
                    <option value="{{$key}}"
                        @isset($column['type'])
                             @if($column['type'] == $key)
                                 selected
                              @endif
                        @endisset
                    >{{$type}}</option>
                @endforeach
        </select>
    </td>
    <td class="text-center">
        <label class="custom-control custom-checkbox">
            <input type="checkbox"
                   class="custom-control-input"
                   value="1"
                   @if(($column['fillable'] ?? null) === '1')
                   checked
                   @endif
                   name="columns[{{$column['name'] ?? '{%=o.field%}'}}][fillable]"
            >
            <span class="custom-control-label"></span>
        </label>
    </td>
    <td class="text-center">
        <label class="custom-control custom-checkbox">
            <input type="checkbox"
                   class="custom-control-input"
                   value="1"
                   @if(($column['guarded'] ?? null) === '1')
                        checked
                   @endif
                   name="columns[{{$column['name'] ?? '{%=o.field%}'}}][guarded]"
            >
            <span class="custom-control-label"></span>
        </label>
    </td>
    <td class="text-center">
        <label class="custom-control custom-checkbox">
            <input type="checkbox"
                   class="custom-control-input"
                   value="1"
                   @if(($column['nullable'] ?? null) === '1')
                        checked
                   @endif
                   name="columns[{{$column['name'] ?? '{%=o.field%}'}}][nullable]"
            >
            <span class="custom-control-label"></span>
        </label>
    </td>
    <td class="text-center">
        <label class="custom-control custom-checkbox">
            <input type="checkbox"
                   class="custom-control-input"
                   value="1"
                   @if(($column['unique'] ?? null) === '1')
                        checked
                   @endif
                   name="columns[{{$column['name'] ?? '{%=o.field%}'}}][unique]"
            >
            <span class="custom-control-label"></span>
        </label>
    </td>
    <td class="text-center">
        <label class="custom-control custom-checkbox">
            <input type="checkbox"
                   class="custom-control-input"
                   value="1"
                   @if(($column['hidden'] ?? null) === '1')
                        checked
                   @endif
                   name="columns[{{$column['name'] ?? '{%=o.field%}'}}][hidden]"
            >
            <span class="custom-control-label"></span>
        </label>
    </td>
</tr>