<div class="wrapper-md">
    <div class="bg-white">


        <div class="form-group">
            <label class="col-lg-2 control-label">Заголовок веб-сайта</label>

            <div class="col-lg-10">
                <input type="text" class="form-control" name="site_title" value="{{$site_title or '' }}">
                <small class="help-block m-b-none">По умолчанию
                </small>
            </div>
        </div>


        <div class="form-group">
            <label class="col-lg-2 control-label">Краткое описание</label>

            <div class="col-lg-10">
                <input type="text" data-role="tagsinput" class="form-control" name="site_keywords"
                       value="{{$site_keywords or '' }}">
                <small class="help-block m-b-none">По умолчанию
                </small>
            </div>
        </div>


        <div class="form-group">
            <label class="col-lg-2 control-label">Краткое описание</label>

            <div class="col-lg-10">
                <textarea class="form-control no-resize" name="site_description"
                          rows="4">{{$site_description or ''}}</textarea>
                <small class="help-block m-b-none">Объясните в нескольких словах, о чём этот сайт.
                </small>
            </div>
        </div>

        <div class="line line-dashed b-b line-lg"></div>

        <div class="form-group">
            <label class="col-lg-2 control-label">Адрес</label>

            <div class="col-lg-10">
                <input type="text" class="form-control" name="site_adress" value="{{$site_adress or '' }}">
                <small class="help-block m-b-none">Физический или юридический адрес организации</small>
            </div>
        </div>


        <div class="line line-dashed b-b line-lg"></div>

        <div class="form-group">
            <label class="col-lg-2 control-label">Телефон</label>

            <div class="col-lg-10">
                <input type="text" class="form-control" name="site_phone" value="{{ $site_phone or '' }}">
            </div>
        </div>


        <div class="line line-dashed b-b line-lg"></div>

        <div class="form-group">
            <label class="col-lg-2 control-label">Адрес e-mail</label>

            <div class="col-lg-10">
                <input type="email" class="form-control" name="site_email" value="{{ $site_email or '' }}">
                <small class="help-block m-b-none">Этот адрес используется в целях администрирования.
                    Например, для уведомления о новых пользователях.
                </small>
            </div>
        </div>

    </div>
</div>