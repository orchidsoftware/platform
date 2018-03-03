<div class="form-group{{ $errors->has($oldName) ? ' has-error' : '' }}">
    @if(isset($title))
        <label for="{{$id}}">{{$title}}</label>
    @endif
    <select @include('dashboard::partials.fields.attributes', ['attributes' => $attributes])>
        @foreach($options as $key => $option)
            <option value="{{$key}}"
                @if(isset($value))
                    @if (is_array($value) && in_array($key, $value)) selected
                    @elseif (isset($value[$key]) && $value[$key] == $option) selected
                    @elseif ($key === $value) selected
                    @endif
                @endif
            >{{$option}}</option>
        @endforeach
    </select>
    @if(isset($help))
        <p class="help-block">{{$help}}</p>
    @endif
</div>
@include('dashboard::partials.fields.hr', ['show' => $hr ?? true])
