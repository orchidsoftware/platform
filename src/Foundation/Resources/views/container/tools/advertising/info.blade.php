<div class="nav-tabs-alt">
    <ul class="nav nav-tabs nav-justified">
        @foreach($locales as $code => $lang)
            <li @if ($loop->first) class="active" @endif>
                <a data-target="#local-{{$code}}" role="tab" data-toggle="tab"
                   aria-expanded="true">{{$lang['native']}}</a>
            </li>
        @endforeach
        <li>
            <a data-target="#tech" role="tab" data-toggle="tab"
               aria-expanded="true">Общее</a>
        </li>
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
                                   value="@if($termTaxonomy->exists) {{$termTaxonomy->term->getContent('name')}}@endif"
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


        <div class="tab-pane" id="tech">
            <div class="wrapper-md">

                <input type="hidden" name="taxonomy" value="category">
                <input type="hidden" name="term_id" @if($termTaxonomy->exists)value="{{$termTaxonomy->term->id}}" @else value="0" @endif>

                <div class="form-group">
                    <label class="col-sm-2 control-label">Родительская категория</label>
                    <div class="col-sm-10">

                        <select data-placeholder="Select Category" name="parent_id" class="chosen-select form-control">

                            <option value="0">Без секции</option>



                            @foreach($category as  $value)


                                <option value="{{$value->id}}"
                                @if($termTaxonomy->exists && $termTaxonomy->parent_id == $value->id) selected @endif  >
                                {{$value->term->getContent('name')}}</option>


                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="form-group m-t-md">
                    <label class="col-sm-2 control-label">Ссылка</label>
                    <div class="col-sm-10">
                        <input type="text" name="slug" @if($termTaxonomy->exists) value="{{$termTaxonomy->term->slug}}"
                               @endif required class="form-control" placeholder="news">
                    </div>
                </div>


            </div>
        </div>


    </div>

</div>