<fieldset class="row g-0 mb-3">
    @if(!empty($title) || !empty($description))
        <div class="col p-0 px-3">
            <legend class="text-body-emphasis px-2 mt-2">
                {{ __($title ?? '') }}

                @if(!empty($description))
                    <p class="small text-muted mt-2 mb-0 text-balance">
                        {!! __($description  ?? '') !!}
                    </p>
                @endif
            </legend>
        </div>
    @endif
    <div class="col-12 {{!$vertical ? 'col-md-7' : ''}} shadow-sm h-100">
        @if($commandBar && $topCommandBar)
            <div class="bg-light px-4 py-3 d-flex justify-content-end rounded-top gap-2">
                @foreach($commandBar as $command)
                    <div>
                        {!! $command !!}
                    </div>
                @endforeach
            </div>
        @endif

        <div class="bg-white d-flex flex-column layout-wrapper {{ empty($commandBar) ? 'rounded' : ($topCommandBar ? 'rounded-bottom' : 'rounded-top') }}">
            @foreach($manyForms as $key => $layouts)
                @foreach($layouts as $layout)
                    {!! $layout ?? '' !!}
                @endforeach
            @endforeach
        </div>

        @if($commandBar && !$topCommandBar)
            <div class="bg-light px-4 py-3 d-flex justify-content-end rounded-bottom gap-2">
                @foreach($commandBar as $command)
                    <div>
                        {!! $command !!}
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</fieldset>

