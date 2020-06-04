<nav aria-label="breadcrumb">
    <ol class="breadcrumb padder m-0">
        @foreach (Breadcrumbs::current() as $crumbs)
            @if ($crumbs->url() && !$loop->last)
                <li class="breadcrumb-item">
                    <a href="{{ $crumbs->url() }}">
                        {{ $crumbs->title() }}
                    </a>
                </li>
            @else
                <li class="breadcrumb-item active">
                    {{ $crumbs->title() }}
                </li>
            @endif
        @endforeach
    </ol>
</nav>
