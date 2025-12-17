@forelse ($results as $group)

    @empty(!$group['label'])
        <div class="hidden-folded text-muted small">
            {{ $group['label'] }}
        </div>
    @endempty

    @foreach ($group['result'] as $item)
        <div class="p-2 list-group-item-action d-flex gap-3 align-items-start position-relative rounded overflow-hidden">

            @empty(!$item->image())
                <div class="thumb-sm rounded overflow-hidden">
                    <img src="{{ $item->image() }}" alt="{{ $item->title() }}">
                </div>
            @endempty

            <div class="d-flex flex-column">
                <div class="text-balance">
                    <a href="{{ $item->url() }}"
                       class="stretched-link link-offset-2 link-underline-opacity-25 link-underline-opacity-100-hover">
                        {{ $item->title() }}
                    </a>
                </div>
                <div class="text-muted small text-balance">
                    {{ $item->subTitle() }}
                </div>
            </div>
        </div>
    @endforeach

@empty
    <p class="ms-3 me-3 mb-0 text-center">
        {{ __('There are no records in this view.') }}
    </p>
@endforelse
