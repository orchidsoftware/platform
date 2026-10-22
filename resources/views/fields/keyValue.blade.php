@php($locked = $disabled || $readonly)
<div class="key-value"
     data-controller="key-value"
     data-key-value-name-value="{{ $name }}"
     data-key-value-disabled-value="{{ $disabled ? 'true' : 'false' }}"
     data-key-value-locked-value="{{ $locked ? 'true' : 'false' }}"
>
    <input type="hidden" name="{{ $name }}[0][key]" value="" data-key-value-target="empty" @if($form ?? null) form="{{ $form }}" @endif @disabled($disabled || count($value) > 0)>
    <input type="hidden" name="{{ $name }}[0][value]" value="" data-key-value-target="empty" @if($form ?? null) form="{{ $form }}" @endif @disabled($disabled || count($value) > 0)>
    <div class="table-responsive">
        <table class="table table-bordered mb-0">
            <thead>
            <tr>
                <th scope="col">{{ __($keyLabel) }}</th>
                <th scope="col">{{ __($valueLabel) }}</th>
                @if(! $locked && ($reorderableRows || $removableRows))
                    <th scope="col" class="text-end text-nowrap"></th>
                @endif
            </tr>
            </thead>
            <tbody data-key-value-target="rows">
            @foreach($value as $key => $row)
                @include('orchid::partials.fields.keyValueRow', ['index' => $key])
            @endforeach
            </tbody>
        </table>
    </div>

    @if($addableRows && ! $locked)
        <div class="mt-2">
            <button type="button" data-action="key-value#addRow" class="btn btn-link btn-sm text-muted">
                <x-orchid-icon :id="null" path="bs.plus-circle" class="me-2"/>
                <span>{{ __($addRowLabel) }}</span>
            </button>
        </div>
    @endif

    <template data-key-value-target="template">
        @include('orchid::partials.fields.keyValueRow', ['row' => ['key' => '', 'value' => ''], 'index' => '{index}'])
    </template>
</div>
