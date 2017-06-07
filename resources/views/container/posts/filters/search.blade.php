<div class="form-group">
    <label class="control-label">Поиск по содержанию</label>
    <input type="text" name="search" value="{{$request->get('search')}}"
           placeholder="{{trans('dashboard::common.search_posts')}}" class="form-control" maxlength="200"
           autocomplete="off">
</div>
