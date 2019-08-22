@component($typeForm,get_defined_vars())
    <button type="button"
            class="btn btn-link dropdown-item"
            data-action="screen--base#targetModal"
            data-modal-title="{{ $title ?? '' }}"
            data-modal-key="{{ $modal ?? '' }}"
            data-modal-action="{{ $action }}">
        <i class="{{ $icon ?? '' }} m-r-xs"></i>{{ $name ?? '' }}
    </button>
@endcomponent
