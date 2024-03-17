@component($typeForm, get_defined_vars())
    <div
        data-controller="datetime"
         class="input-group"
        {{ $dataAttributes }}>
        <input type="text"
               placeholder="{{$placeholder ?? ''}}"
               {{ $attributes }}
               autocomplete="off"
               data-datetime-target="instance"
        >

        @if(true === $allowEmpty)
            <div class="input-group-append bg-white">
                <a class="input-group-text h-100 text-muted"
                   title="clear"
                   data-action="click->datetime#clear">
                        <x-orchid-icon path="bs.x-lg" class="m-0 p-0"/>
                    </a>
                </div>
            @endif

        @foreach($quickDates as $name => $value)
            <label class="btn btn-default" data-action="click->datetime#setValue" data-value="{{ $value }}">
                {{ $name }}
            </label>
        @endforeach
        </div>
@endcomponent




