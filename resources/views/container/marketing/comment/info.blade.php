<div class="wrapper-md">
    <div class="bg-white">


        <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
            <label class="col-lg-2 control-label">Содержание</label>

            <div class="col-lg-10">
                <textarea rows="10" name="content" class="form-control">{{$comment->content or ''}}</textarea>
                <small class="help-block m-b-none">Комментарий пользователя
                </small>
            </div>
        </div>

        <div class="line line-dashed b-b line-lg"></div>

        <div class="form-group{{ $errors->has('approved') ? ' has-error' : '' }}">
            <label class="col-lg-2 control-label">Проверка</label>

            <div class="col-lg-10">
                <label class="i-switch m-t-xs m-r">
                    <input type="checkbox" {{$comment->isApproved() ? 'checked' : '' }} value="1" name="approved">
                    <i></i>
                </label>
                <small class="help-block m-b-none">Отображать комментарий</small>
            </div>
        </div>


    </div>
</div>