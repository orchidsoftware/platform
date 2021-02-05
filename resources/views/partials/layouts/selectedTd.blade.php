<div class="dropdown-item">
    <div class="form-check h-auto w-100">
        <input type="checkbox"
               checked
               class="custom-control-input"
               id="{{ $slug }}"
               form="table-columns-select"
               data-action="table#toggleColumn"
               data-default-hidden="{{ $defaultHidden }}"
               data-column="{{ $slug }}"
        >
        <label class="form-check-label d-block w-100 cursor" for="{{ $slug }}">
            {{ $title }}
        </label>
    </div>
</div>
