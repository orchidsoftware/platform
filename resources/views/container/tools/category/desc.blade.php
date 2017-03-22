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
                <div class="wrapper-md">


                    <div class="form-group">
                        <label class="col-sm-2 control-label">Название</label>
                        <div class="col-sm-10">
                            <input name="content[{{$code}}][name]"
                                   value="@if($termTaxonomy->exists) {{$termTaxonomy->term->getContent('name',$code)}}@endif"
                                   required class="form-control" placeholder="Название">
                        </div>
                    </div>


                    <div class="line line-dashed b-b line-lg"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">Описание</label>
                        <div class="col-sm-10">
                            <textarea name="content[{{$code}}][body]"
                                      required class="form-control summernote" placeholder="Название">
                                   @if($termTaxonomy->exists) {{$termTaxonomy->term->getContent('body')}}@endif
                            </textarea>
                        </div>
                    </div>


                </div>
            </div>
        @endforeach

    </div>

</div>