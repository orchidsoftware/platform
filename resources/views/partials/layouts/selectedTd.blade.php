<div class="dropdown-item">
    <div class="custom-control custom-checkbox h-auto">
        <input type="checkbox"
               checked
               class="custom-control-input"
               id="{{ $slug }}"
               form="table-columns-select"
               data-action="layouts--table#toggleColumn"
               data-default-hidden="{{ $defaultHidden }}"
               data-column="{{ $slug }}"
        >
        <label class="custom-control-label d-block w-full" for="{{ $slug }}">
            {{ $title }}
        </label>
    </div>
</div>
