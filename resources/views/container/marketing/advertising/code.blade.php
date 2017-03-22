@if(count($locales) > 1)
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
@endif


<div class="row-row">
    <div class="tab-content">

        @foreach($locales as $code => $lang)
            <div class="tab-pane @if ($loop->first) active  @endif" id="local-{{$code}}">


                <div class="wrapper-md">


                    <div class="row">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Статус</label>
                            <div class="col-sm-10">

                                <label class="i-switch bg-info m-t-xs m-r">
                                    <input type="checkbox" name="options[locale][{{$code}}]"
                                           {{$adv->checkLanguage($code)  ? 'checked' : ''}} value="true">
                                    <i></i>
                                </label>


                            </div>
                        </div>


                        <div class="col-md-12 code-block-wrapper">
                            <div id="ace-code-block-{{$code}}" style="width: 100%; min-height: 70vh;"></div>
                            <input type="hidden" id="hidden-code-{{$code}}" value="{{$adv->getContent('code',$code)}}"
                                   name="content[{{$code}}][code]">
                        </div>
                    </div>


                </div>

            </div>



            <script>
                $(function () {
                    var editor{{$code}} = ace.edit('ace-code-block-{{$code}}');
                    editor{{$code}}.getSession().setMode('ace/mode/javascript');
                    editor{{$code}}.setTheme('ace/theme/monokai');

                    var input{{$code}} = $('#hidden-code-{{$code}}');
                    editor{{$code}}.getSession().setValue(input{{$code}}.val());
                    editor{{$code}}.getSession().on('change', function () {
                        input{{$code}}.val(editor{{$code}}.getSession().getValue());
                    });

                });
            </script>

        @endforeach


    </div>

</div>








