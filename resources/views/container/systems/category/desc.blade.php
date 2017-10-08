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
                        <label class="col-sm-2 control-label">{{trans('dashboard::systems/category.name')}}</label>
                        <div class="col-sm-10">
                            <input name="content[{{$code}}][name]"
                                   value="{{optional($termTaxonomy->term)->getContent('name',$code)}}"
                                   required class="form-control"
                                   placeholder="{{trans('dashboard::systems/category.name')}}">
                        </div>
                    </div>


                    <div class="line line-dashed b-b line-lg"></div>

                    <div class="form-group">
                        <label class="col-sm-2 control-label">{{trans('dashboard::systems/category.descriptions')}}</label>
                        <div class="col-sm-10">
                            <textarea name="content[{{$code}}][body]"
                                      required class="form-control summernote"
                                      placeholder="{{trans('dashboard::systems/category.descriptions')}}">
                                   {{optional($termTaxonomy->term)->getContent('body',$code)}}
                            </textarea>
                        </div>
                    </div>


                </div>
            </div>
        @endforeach

    </div>

</div>
