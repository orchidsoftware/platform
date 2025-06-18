<div
    class="mb-3"
    data-controller="tabs"
    data-tabs-slug="{{$templateSlug}}"
    data-tabs-active-tab="{{$activeTab}}"
>
    <nav class="d-flex justify-content-center text-nowrap mb-3">
        <div class="bg-body-tertiary rounded overflow-hidden">
            <ul class="nav nav-pills nav-justified d-inline-flex mx-auto px-3 py-2 nav-scroll-bar gap-2" role="tablist">
                @foreach($manyForms as $name => $tab)
                    <li class="nav-item" role="presentation">
                        @if(isset($menuItems[$name]))
                            {!! $tab[0] !!}
                        @else
                            <a
                                @class([
                                    'nav-link',
                                    'active' => $activeTab === $name || ($loop->first && is_null($activeTab))
                                ])
                                data-action="tabs#setActiveTab"
                                href="#tab-{{sha1($templateSlug.$name)}}"
                                data-bs-target="#tab-{{sha1($templateSlug.$name)}}"
                                id="button-tab-{{sha1($templateSlug.$name)}}"
                                aria-selected="false"
                                role="tab"
                                data-bs-toggle="tab">
                                {!! $name !!}
                            </a>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </nav>


    <section class="tab-content">
        @foreach($manyForms as $name => $forms)
            @if(!isset($menuItems[$name]))
                <div role="tabpanel"
                     id="tab-{{sha1($templateSlug.$name)}}"
                     @class([
                        'tab-pane',
                        'active' => $activeTab === $name || ($loop->first && is_null($activeTab))
                     ])
                >
                    @foreach($forms as $form)
                        {!! $form !!}
                    @endforeach
                </div>
            @endif
        @endforeach
    </section>
</div>
