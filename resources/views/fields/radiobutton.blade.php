<div class="btn-group p-0">
    @foreach($options as $key => $option)
        <input {{ $attributes->except('id') }}
               @checked($active($key, $value))
               value="{{ $key }}" id="{{ $key }}-{{$id}}">
        <label class="btn btn-default" for="{{ $key }}-{{$id}}">{{ $option }}</label>
    @endforeach
</div>
