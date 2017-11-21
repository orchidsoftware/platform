<div class="nav-tabs-alt">
    <ul class="nav nav-tabs nav-justified">
        @if(count($locales) > 1)
            @foreach($locales as $code => $lang)
                <li @if ($loop->first) class="active" @endif>
                    <a data-target="#local-{{$code}}" role="tab" data-toggle="tab"
                       aria-expanded="true">{{$lang['native']}}</a>
                </li>
            @endforeach
        @endif
    </ul>
</div>


<div class="row-row">
    <div class="tab-content">


        @foreach($locales as $code => $lang)
            <div class="tab-pane @if ($loop->first) active  @endif" id="local-{{$code}}">
                <div class="wrapper-lg">

                    <div class="container">

                        {!! generate_form($fields, optional($termTaxonomy->term), $code) !!}

                    </div>

                </div>
            </div>
        @endforeach

    </div>

</div>
