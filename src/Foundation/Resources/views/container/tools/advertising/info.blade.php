<div class="wrapper-md">
    <div class="form-group m-t-md">
        <label class="col-sm-2 control-label">Имя</label>
        <div class="col-sm-10">
            <input type="text" name="slug" required class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Описание</label>
        <div class="col-sm-10">
            <textarea name="description"
                      required class="form-control summernote" placeholder="Название">
            </textarea>
        </div>
    </div>

    <div class="form-group">
            <label class="col-sm-2 control-label">Категория</label>
            <div class="col-sm-10">

                <select data-placeholder="Select Category" name="parent_id" class="chosen-select form-control">
                    @foreach($categories as $categoryCode => $categoryLabel)
                        <option value="{{$categoryCode}}">
                            {{$categoryLabel}}</option>
                    @endforeach
                </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">Расписание</div>
        <div class="col-sm-10">
            @foreach($weekDays as $dayCode => $dayLabel)
            <label class="checkbox-inline i-checks">
                <input type="checkbox" value="{{$dayCode}}"><i></i> {{$dayLabel}}
            </label>
            @endforeach
        </div>
    </div>
</div>