@php($repeaterPlaceholder = '__repeater_'.hash('sha256', $name).'__')
<div class="repeater"
     data-controller="repeater"
     data-repeater-index="{{ count($value) }}"
     data-repeater-rows="{{ $maxRows }}"
     data-repeater-placeholder="{{ $repeaterPlaceholder }}"
     data-repeater-name="{{ $name }}"
     data-repeater-readonly="{{ $readonly ? 'true' : 'false' }}"
     data-repeater-disabled="{{ $disabled ? 'true' : 'false' }}"
>
    @unless($disabled)
    <input type="hidden" name="{{ $name }}" value="" data-repeater-target="empty" @if($form ?? null) form="{{ $form }}" @endif>
    @endunless
    <fieldset class="border-0 p-0 m-0" @disabled($disabled || $readonly)>
    <div class="vstack gap-3" data-repeater-target="rows">
        @foreach($value as $key => $row)
            @include('orchid::partials.fields.repeaterRow', ['row' => $row, 'key' => $key])
        @endforeach
    </div>

    <div class="mt-3" data-repeater-target="addRow">
        <button type="button" class="btn btn-outline-secondary" data-action="repeater#addRow">
            <x-orchid-icon :id="null" path="bs.plus" class="me-2"/>
            {{ __($addRowLabel) }}
        </button>
    </div>

    <template data-repeater-target="template">
        @include('orchid::partials.fields.repeaterRow', ['row' => [], 'key' => $repeaterPlaceholder])
    </template>
    </fieldset>
</div>
