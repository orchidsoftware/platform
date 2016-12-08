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
    <div class="cell scrollable hover">
        <div class="cell-inner bg-white">
            <div class="tab-content">

                @foreach($locales as $code => $lang)
                    <div class="tab-pane @if ($loop->first) active  @endif" id="local-{{$code}}">
                        <div class="wrapper-md">



                            <div class="form-group">
                                <label class="col-sm-2 control-label">Название</label>
                                <div class="col-sm-10">
                                    <input name="content[{{$code}}][name]" value="{{$section->content[$code]['name'] or ''}}" required class="form-control" placeholder="Название">
                                </div>
                            </div>


                        </div>
                    </div>
                @endforeach


                <div class="tab-pane" id="tech">
                    <div class="wrapper-md">



                        <div class="form-group m-t-md">
                            <label class="col-sm-2 control-label">Ссылка</label>
                            <div class="col-sm-10">
                                <input type="text" name="slug" value="{{$section->slug or ''}}" required class="form-control" placeholder="news">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Родительская секция</label>
                            <div class="col-sm-10">
                                <select class="form-control" name="section_id">
                                    <option value="">Без секции</option>
                                    @foreach($sections as $key => $value)
                                        <option value="{{$value->id}}"
                                      >  @if($section->section_id == $value->id) selected @endif
                                            >{{$value->content[$language]['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>







                    </div>
                </div>


            </div>
        </div>
    </div>
</div>