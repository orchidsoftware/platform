<div class="nav-tabs-alt bg-white-only">
    <ul class="nav nav-tabs padder bg-light" role="tablist">
        @foreach($manyForms as $name => $tab)
            <li class="nav-item">
                <a class="nav-link @if ($loop->first) active @endif" data-target="#tab-{{str_slug($name)}}" role="tab" data-toggle="tab">
                    {!! $name !!}
                </a>
            </li>
        @endforeach
    </ul>
</div>


<!-- main content  -->
<section>
    <div class="bg-white-only bg-auto no-border-xs">
        <div class="tab-content">
            @foreach($manyForms as $name => $forms)
                <div role="tabpanel" class="tab-pane @if ($loop->first) active @endif"
                     id="tab-{{str_slug($name)}}">

                    @foreach($forms as $form)
                        {!! $form !!}
                    @endforeach

                </div>
            @endforeach
        </div>
    </div>
</section>
<!-- / main content  -->
