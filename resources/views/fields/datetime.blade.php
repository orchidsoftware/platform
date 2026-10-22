<div
    data-controller="datetime"
    class="input-group"
    @if($attributes['readonly'] ?? false) data-field-readonly @endif
    {{ $dataAttributes }}>
    <input type="text"
           placeholder="{{ __($placeholder ?? '') }}"
           {{ $attributes->except('placeholder') }}
           autocomplete="off"
           data-datetime-target="instance"
    >

    @if(true === $allowEmpty)
        <button type="button" class="btn btn-default"
                title="{{ __('Clear') }}" aria-label="{{ __('Clear') }}"
                data-action="datetime#clear"
                @disabled(($attributes['disabled'] ?? false) || ($attributes['readonly'] ?? false))>
            <x-orchid-icon path="bs.x-lg" class="m-0 p-0"/>
        </button>
    @endif

    @foreach($quickDates as $name => $value)
        <label class="btn btn-default" data-action="click->datetime#setValue" data-value="{{ $value }}">
            {{ $name }}
        </label>
    @endforeach
</div>
