<div class="wrapper-md">
    <div class="bg-white">
        <form class="form-horizontal" action="#" method="post">


            <div class="form-group">
                <label class="col-lg-2 control-label">Краткое описание</label>

                <div class="col-lg-10">
                    <input type="text" name="site_descriptions" class="form-control" value="">
                    <small class="help-block m-b-none">Объясните в нескольких словах, о чём этот сайт.
                    </small>
                </div>
            </div>

            <div class="line line-dashed b-b line-lg"></div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Адрес</label>

                <div class="col-lg-10">
                    <input type="text" class="form-control" name="site_adress" value="">
                    <small class="help-block m-b-none">Физический или юридический адрес организации</small>
                </div>
            </div>


            <div class="line line-dashed b-b line-lg"></div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Телефон</label>

                <div class="col-lg-10">
                    <input type="text" class="form-control" name="site_phone" value="">
                </div>
            </div>


            <div class="line line-dashed b-b line-lg"></div>

            <div class="form-group">
                <label class="col-lg-2 control-label">Адрес e-mail</label>

                <div class="col-lg-10">
                    <input type="email" class="form-control" name="site_email" value="">
                    <small class="help-block m-b-none">Этот адрес используется в целях администрирования.
                        Например, для уведомления о новых пользователях.
                    </small>
                </div>
            </div>


            <div class="form-group text-center">
                <div class="col-md-4 col-md-offset-8">

                    {!! csrf_field() !!}

                    <button type="submit" class="btn btn-sm btn-info">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>