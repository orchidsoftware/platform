<div id="accordion-{{ $templateSlug }}" class="accordion mb-3">
    @foreach($manyForms as $name => $forms)
        @php
            $collapseId = 'collapse-' . \Illuminate\Support\Str::slug($name);
            $collapseIsOpen = in_array($name, $open);
        @endphp

        <a
            href="#{{ $collapseId }}"
            data-bs-target="#{{ $collapseId }}"
            class="accordion-heading nav-link py-2 px-1 d-flex align-items-center"
            data-bs-toggle="collapse"
            aria-expanded="{{ $collapseIsOpen ? 'true' : 'false' }}"
            role="button"
            aria-controls="{{ $collapseId }}"
        >
            <x-orchid-icon path="bs.chevron-right" class="small me-2" />
            {!! $name !!}
        </a>

        <div
            id="{{ $collapseId }}"
            class="mt-2 collapse @if ($collapseIsOpen) show @endif"
            @if (! $stayOpen)
                data-bs-parent="#accordion-{{ $templateSlug }}"
            @endif
        >
            @foreach($forms as $form)
                {!! $form !!}
            @endforeach
        </div>
    @endforeach
</div>
