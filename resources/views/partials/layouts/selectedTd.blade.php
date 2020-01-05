<div class="dropdown-item">
    <div class="custom-control custom-checkbox h-auto w-full">
        <input type="checkbox"
               checked
               class="custom-control-input"
               id="{{ $slug }}"
               form="table-columns-select"
               data-action="layouts--table#toggleColumn"
               data-default-hidden="{{ $defaultHidden }}"
               data-column="{{ $slug }}"
        >
        <label class="custom-control-label d-block w-full cursor" for="{{ $slug }}">
            {{ $title }}
        </label>
    </div>
</div>
