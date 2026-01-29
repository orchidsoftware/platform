@forelse ($results as $group)

    @empty(!$group['label'])
        <div class="hidden-folded text-muted small">
            {{ $group['label'] }}
        </div>
    @endempty

    @foreach ($group['result'] as $item)
        <div
            tabindex="0"
            data-search-item
            data-action="keydown->search#keydown"
            class="p-2 search-result-item d-flex gap-3 align-items-start position-relative rounded overflow-hidden">

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

            <div class="search-result-item-icon ms-auto my-auto me-2 opacity-50">
                <x-orchid-icon path="bs.arrow-return-left" width="1.25rem" height="1.25rem"/>
            </div>
        </div>
    @endforeach

@empty
    <p class="mb-0 text-center p-5 text-center bg-body-tertiary rounded-3 text-balance">
        {{ __('There are no records in this view.') }}
    </p>
@endforelse
