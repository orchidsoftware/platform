<tr>
    <td class="text-left">
        <button type="button" class="btn btn-sm btn-link" data-action="components--boot#removeColumn">
            <i class="icon-trash m-r-xs"></i> {{$relation['model'] ?? '{%=o.field%}'}}
        </button>
        <input type="hidden"  value="{{$relation['model'] ?? '{%=o.field%}'}}" name="columns[{{$relation['model'] ?? '{%=o.field%}'}}][model]">
    </td>

    <td class="text-center">
        <select name="model" class="form-control">
            @foreach ($relationTypes as $key => $relation)
                <option value="{{$key}}">{{$relation}}</option>
            @endforeach
        </select>
    </td>
    <td class="text-center">
        <select name="model"
                class="form-control">
            <option value="null">Don't Use</option>
            <option value="id">id</option>
            <option value="name">name</option>
            <option value="email">email</option>
            <option value="password">password</option>
            <option value="test">test</option>
            <option value="trhrhtrhrt">trhrhtrhrt</option>
        </select>
    </td>
    <td class="text-center">
        <select name="model"
                class="form-control">
            <option value="null">Don't Use</option>
            <option value="id">id</option>
            <option value="name">name</option>
            <option value="email">email</option>
            <option value="password">password</option>
            <option value="test">test</option>
            <option value="trhrhtrhrt">trhrhtrhrt</option>
        </select>
    </td>
    <td class="text-center">
        <button type="button"
                class="btn btn-danger"
                data-action="components--boot#removeColumn"
        >
            <i class="icon-trash"></i>
        </button>
    </td>
</tr>