<div
    data-controller="tabs"
    data-tabs-slug="{{$templateSlug}}"
>
    <div class="nav-tabs-alt">
        <ul class="nav nav-tabs" role="tablist">
            @foreach($manyForms as $name => $tab)
                <li class="nav-item">
                    <a class="nav-link @if ($loop->first) active @endif"
                       data-action="tabs#setActiveTab"
                       data-bs-target="#tab-{{\Illuminate\Support\Str::slug($name)}}"
                       id="button-tab-{{\Illuminate\Support\Str::slug($name)}}"
                       role="tablist"
                       data-bs-toggle="tab">
                        {!! $name !!}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <!-- main content -->
    <section class="mb-3">
        <div class="no-border-xs">
            <div class="tab-content">
                @foreach($manyForms as $name => $forms)
                    <div role="tabpanel" class="tab-pane @if ($loop->first) active @endif"
                         id="tab-{{\Illuminate\Support\Str::slug($name)}}">
                            @foreach($forms as $form)
                                {!! $form !!}
                            @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- / main content -->
</div>
