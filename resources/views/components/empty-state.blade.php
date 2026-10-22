<div {{ $attributes->class([
    'empty-state',
    'd-flex',
    'flex-column',
    'align-items-center',
    'justify-content-center',
    'p-4',
    'text-center',
    'text-balance',
]) }}>
    @if(filled($icon))
        <x-orchid-icon :path="$icon"
                       width="1.75rem"
                       height="1.75rem"
                       class="text-secondary opacity-75 mb-2"/>
    @endif

    @if(filled($title))
        <h3 class="h5 fw-normal text-body-emphasis mb-1">
            {{ $title }}
        </h3>
    @endif

    @if(filled($description))
        <p class="text-muted mb-0">
            {{ $description }}
        </p>
    @endif

    @if($slot->hasActualContent())
        <div class="mt-3">
            {{ $slot }}
        </div>
    @endif
</div>
