<style>
    .card-header.collapsed .icon-arrow-down:before {
        content: "\E914";
    }
</style>
<div id="accordion">
    @foreach($manyForms as $name => $forms)
        <div class="card">
            <div class="card-header @if ($loop->index) collapsed @endif" id="heading-{{str_slug($name)}}" data-toggle="collapse" data-target="#collapse-{{str_slug($name)}}" aria-expanded="true" aria-controls="collapse-{{str_slug($name)}}">
                <h5 class="mb-0">
                    <span class="btn-link">
                        {!! $name !!}
                    </span>
                    <span class="icon-arrow-down icons pull-right"></span>
                </h5>
            </div>

            <div id="collapse-{{str_slug($name)}}" class="collapse @if (!$loop->index) show @endif" aria-labelledby="heading-{{str_slug($name)}}" data-parent="#accordion">
                <div class="card-body">
                    <div class="padder-v">
                        @foreach($forms as $form)
                            {!! $form !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>