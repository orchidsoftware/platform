<tr data-key-value-target="row" data-key-value-row>
    <td class="p-0 align-middle">
        <input type="text"
               @if($form ?? null) form="{{ $form }}" @endif
               name="{{ $name }}[{{ $index }}][key]"
               value="{{ $row['key'] ?? '' }}"
               placeholder="{{ $keyPlaceholder }}"
               class="form-control"
               aria-label="{{ __($keyLabel) }}"
               data-key-value-cell="key"
               @readonly($readonly || ! $editableKeys)
               @disabled($disabled)
        >
    </td>

    <td class="p-0 align-middle">
        <input type="text"
               @if($form ?? null) form="{{ $form }}" @endif
               name="{{ $name }}[{{ $index }}][value]"
               value="{{ $row['value'] ?? '' }}"
               placeholder="{{ $valuePlaceholder }}"
               class="form-control"
               aria-label="{{ __($valueLabel) }}"
               data-key-value-cell="value"
               @readonly($readonly || ! $editableValues)
               @disabled($disabled)
        >
    </td>

    @if(! $locked && ($reorderableRows || $removableRows))
        <td class="text-end text-nowrap align-middle">
            <div class="d-inline-flex gap-1">
                @if($reorderableRows)
                    <button type="button" class="btn btn-link btn-sm text-muted" data-action="key-value#moveUp" aria-label="{{ __('Move up') }}">
                        <x-orchid-icon :id="null" path="bs.arrow-up"/>
                    </button>
                    <button type="button" class="btn btn-link btn-sm text-muted" data-action="key-value#moveDown" aria-label="{{ __('Move down') }}">
                        <x-orchid-icon :id="null" path="bs.arrow-down"/>
                    </button>
                @endif
                @if($removableRows)
                    <button type="button" class="btn btn-link btn-sm text-muted" data-action="key-value#deleteRow" aria-label="{{ __('Delete row') }}">
                        <x-orchid-icon :id="null" path="bs.trash3"/>
                    </button>
                @endif
            </div>
        </td>
    @endif
</tr>
