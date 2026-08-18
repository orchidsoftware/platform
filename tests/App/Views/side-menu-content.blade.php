<section class="layout" aria-labelledby="side-menu-demo-heading">
    <h2 class="h4 mb-3" id="side-menu-demo-heading">{{ $page['title'] }}</h2>
    <p class="text-muted mb-4">
        {{ $page['description'] }}
    </p>

    <div class="row g-3">
        @foreach (['Projects', 'Members', 'Updates'] as $label)
            <div class="col-sm-4">
                <div class="border rounded p-3 h-100">
                    <div class="small text-muted">{{ $label }}</div>
                    <strong class="fs-4">{{ $loop->iteration * 8 }}</strong>
                </div>
            </div>
        @endforeach
    </div>

    <div style="min-height: 32rem"></div>
</section>
