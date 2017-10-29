<div class="nav-tabs-alt bg-white-only">
        <ul class="nav nav-tabs padder" role="tablist">
            @foreach($tabs as $name => $tab)
                <li @if ($loop->first) class="active" @endif>
                    <a data-target="#tab-{{str_slug($name)}}" role="tab" data-toggle="tab">
                        {!! $name !!}
                    </a>
                </li>
            @endforeach
        </ul>
</div>


<!-- main content  -->
<section class="wrapper-md">
    <div class="bg-white-only bg-auto no-border-xs">
            <div class="tab-content">
                @foreach($tabs as $name => $forms)
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
