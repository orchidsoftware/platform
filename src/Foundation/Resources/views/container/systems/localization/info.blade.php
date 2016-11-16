<div class="wrapper-md">
    <div class="bg-white">
        <form class="form-horizontal" action="#" method="post">


            <div class="form-group">
                <label for="name" class="col-lg-2 control-label">Имя на родном языке</label>

                <div class="col-lg-10">
                    <input id="name" type="text" name="name" class="form-control" value="">
                    <small class="help-block m-b-none">Английский - English, французский - Français, китайский - 普通话
                    </small>
                </div>
            </div>

            <div class="form-group">
                <label for="code" class="col-lg-2 control-label">Код языка</label>

                <div class="col-lg-10">
                    <input id="code" type="text" name="code" class="form-control" value="">
                    <small class="help-block m-b-none">Код языка
                    </small>
                </div>
            </div>

            <div class="line line-dashed b-b line-lg"></div>

            <div class="form-group text-center">
                <div class="col-md-4 col-md-offset-8">

                    {!! csrf_field() !!}

                    <button type="submit" class="btn btn-sm btn-info">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>