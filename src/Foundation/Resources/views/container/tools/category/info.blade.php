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
    <div class="cell scrollable hover">
        <div class="cell-inner bg-white">
            <div class="tab-content">
                @foreach($locales as $code => $lang)
                    <div class="tab-pane @if ($loop->first) active  @endif" id="local-{{$code}}">
                        <div class="wrapper-md">



                            <input name="content[{{$code}}]['name']" required class="form-control">






                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>