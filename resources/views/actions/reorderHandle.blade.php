<span {{ $attributes }}
      data-key="{{ $key }}"
      data-action="{{ $action }}"
      data-controller="reorder"
      data-reorder-sortable-selector-value="{{ $container }}"
      data-reorder-handle-selector-value=".reorder-handle"
      data-success-message="{{ $successMessage ?? __('Item successfully moved') }}"
      data-failure-message="{{ $failureMessage ?? __('Item move failed') }}"
>
    <x-orchid-icon :path="$icon" />
</span>

@pushonce('stylesheets')
    <style>
        .reorder-drag {
            opacity: 0;
        }
        .reorder-handle {
            cursor: move;
        }
    </style>
@endpushonce
