<div id="accordion-{{ $templateSlug }}" class="accordion mb-3">
    @foreach($manyForms as $name => $forms)
        @php
            $collapseId = 'collapse-' . $templateSlug . '-' . \Illuminate\Support\Str::slug($name);
            $headingId = 'heading-' . $templateSlug . '-' . \Illuminate\Support\Str::slug($name);
            $collapseIsOpen = in_array($name, $open);
        @endphp

        <button
            id="{{ $headingId }}"
            type="button"
            data-bs-target="#{{ $collapseId }}"
            @class([
                'accordion-heading nav-link py-2 px-1 d-flex align-items-center',
                'collapsed' => ! $collapseIsOpen,
            ])
            data-bs-toggle="collapse"
            aria-expanded="{{ $collapseIsOpen ? 'true' : 'false' }}"
            aria-controls="{{ $collapseId }}"
        >
            <x-orchid-icon path="bs.chevron-right" class="small me-2" />
            {!! $name !!}
        </button>

        <div
            id="{{ $collapseId }}"
            class="mt-2 collapse @if ($collapseIsOpen) show @endif"
            aria-labelledby="{{ $headingId }}"
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
