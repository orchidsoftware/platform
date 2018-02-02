@if(count($locales) > 1)
    <div class="nav-tabs-alt">
        <ul class="nav nav-tabs nav-justified">
            @foreach($locales as $code => $lang)
                <li class="nav-item">
                    <a class="nav-link @if ($loop->first) active @endif" data-target="#local-{{$code}}" role="tab" data-toggle="tab"
                       aria-expanded="true">{{$lang['native']}}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row-row">
    <div class="tab-content">

        @foreach($locales as $code => $lang)
            <div class="tab-pane @if ($loop->first) active  @endif" id="local-{{$code}}">
                <div class="wrapper-lg">

                    <div class="container">

                        {!! generate_form($behavior->fields(), !$termTaxonomy->exists ? null : optional($termTaxonomy->term)->toArray(), $code,'content') !!}

                    </div>

                </div>
            </div>
        @endforeach

    </div>

</div>
