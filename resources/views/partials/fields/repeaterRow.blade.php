<div class="repeater-item border rounded bg-white"
     data-repeater-target="row"
     data-repeater-row
>
    <div class="d-flex flex-column gap-3 p-3">
        @foreach($fields as $source)
            @php
                $field = clone $source;
                if ($disabled) $field->set('disabled', true);
                if ($readonly) $field->set('readonly', true);
                $fieldName = $field->get('name');
                if (\Illuminate\Support\Arr::has($row, rtrim($fieldName, '.')) && \Illuminate\Support\Arr::get($row, rtrim($fieldName, '.')) === null) {
                    $field->set('value', null);
                }
                $field->id(($idPrefix ?? $id)."-$key-$loop->index-".str_replace(['.', '[', ']'], '-', $fieldName));
                $field->set('prefix', $name."[$key]");
                if ($form ?? null) {
                    $field->set('form', $form);
                }
                $builder = new \Orchid\Screen\Builder([$field], new \Orchid\Screen\Repository($row));
            @endphp

            {!! $builder->generateForm() !!}
        @endforeach
    </div>

    @if($reorderableRows || $cloneableRows || $removableRows)
        <div class="d-flex justify-content-end gap-2 border-top px-3 py-2">
            @if($reorderableRows)
                <button type="button" class="btn btn-link btn-sm text-muted" data-action="repeater#moveUp" title="{{ __('Move up') }}">
                    <x-orchid-icon :id="null" path="bs.arrow-up"/>
                </button>
                <button type="button" class="btn btn-link btn-sm text-muted" data-action="repeater#moveDown" title="{{ __('Move down') }}">
                    <x-orchid-icon :id="null" path="bs.arrow-down"/>
                </button>
            @endif

            @if($cloneableRows)
                <button type="button" class="btn btn-link btn-sm text-muted" data-repeater-clone data-action="repeater#cloneRow" title="{{ __('Duplicate') }}">
                    <x-orchid-icon :id="null" path="bs.copy"/>
                </button>
            @endif

            @if($removableRows)
                <button type="button" class="btn btn-link btn-sm text-muted" data-action="repeater#deleteRow" title="{{ __('Delete row') }}">
                    <x-orchid-icon :id="null" path="bs.trash3"/>
                </button>
            @endif
        </div>
    @endif
</div>
