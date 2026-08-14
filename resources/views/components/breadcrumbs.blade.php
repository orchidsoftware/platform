<nav aria-label="breadcrumb">
    <ol class="breadcrumb px-4 mb-2">
        @foreach ($items as $item)
            <li
                @class([
                    'breadcrumb-item text-truncate',
                    'active' => $item['current'] ?? false,
                ])
            >
                @isset($item['breadcrumbs'])
                    <button
                        class="btn btn-sm border-0 lh-1 link-secondary d-inline-flex align-items-center p-0"
                        type="button"
                        data-bs-toggle="dropdown"
                        data-bs-boundary="viewport"
                        aria-expanded="false"
                    >
                        <x-orchid-icon path="bs.three-dots" aria-hidden="true"/>
                    </button>

                    <ul class="dropdown-menu dropdown-menu-arrow p-1">
                        @foreach ($item['breadcrumbs'] as $breadcrumb)
                            <li>
                                @if ($breadcrumb->url())
                                    <a class="dropdown-item rounded-1 px-2 py-2"
                                       href="{{ $breadcrumb->url() }}"
                                    >
                                        {{ $breadcrumb->title() }}
                                    </a>
                                @else
                                    <span class="dropdown-item-text px-2 py-2">
                                        {{ $breadcrumb->title() }}
                                    </span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @else
                    @if ($item['breadcrumb']->url() && ! $item['current'])
                        <a class="link-secondary text-decoration-none"
                           href="{{ $item['breadcrumb']->url() }}"
                        >
                            {{ $item['breadcrumb']->title() }}
                        </a>
                    @else
                        {{ $item['breadcrumb']->title() }}
                    @endif
                @endif
            </li>
        @endforeach
    </ol>
</nav>
