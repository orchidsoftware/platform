<div class="nav-tabs-alt">
    <ul class="nav nav-tabs nav-justified">
        @foreach($locales as $code => $lang)
            <li @if ($loop->first) class="active" @endif>
                <a data-target="#local-{{$code}}" role="tab" data-toggle="tab"
                   aria-expanded="true">{{$lang['native']}}</a>
            </li>
        @endforeach
    </ul>
</div>


<div class="row-row">
    <div class="tab-content">

        @foreach($locales as $code => $lang)
            <div class="tab-pane @if ($loop->first) active  @endif" id="local-{{$code}}">


                <div class="wrapper-md">


                    <div class="row">
                        <div class="col-md-6 code-block-wrapper">
                            <div id="code-editor" class="code-block" style="width: 100%; min-height: 50vh;"></div>
                        </div>
                        <div class="col-md-6">

                            <div id="preview-context" class="panel b box-shadow-lg text-center" style="width: 100%; min-height: 50vh;">
                            </div>
                        </div>
                    </div>




                    <input type="hidden" id="code-data" name="code" @if(isset($item)) value="{{$item->file_name}}" @endif>




                </div>

            </div>
        @endforeach




    </div>

</div>








