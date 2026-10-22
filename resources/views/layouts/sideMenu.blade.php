<nav class="bg-white rounded p-2 mb-3" aria-label="{{ __($label) }}" data-side-menu>
    <button class="btn btn-block border-0 d-flex align-items-center justify-content-between d-md-none collapsed"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#{{ $domId }}-collapse"
            data-side-menu-toggle
            aria-expanded="false"
            aria-controls="{{ $domId }}-collapse"
    >
        <span>{{ __($label) }}</span>
        <x-orchid-icon path="bs.list"
                       :id="null"
                       :role="null"
                       aria-hidden="true"
                       focusable="false"/>
    </button>

    <div class="collapse d-md-block" id="{{ $domId }}-collapse" data-side-menu-collapse>
        <ul class="nav nav-pills flex-column gap-1 mb-0 pt-2 pt-md-0"
            id="menu-{{ $domId }}"
            data-side-menu-list
        >
            {!! $navigations !!}
        </ul>
    </div>
</nav>
