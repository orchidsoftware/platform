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
            <textarea name="description" required class="form-control"></textarea>
        </div>
    </div>

    <div class="form-group">
            <label class="col-sm-2 control-label">Категория</label>
            <div class="col-sm-10">

                <select data-placeholder="Select Category" name="category_id" class="chosen-select form-control">
                    @foreach($categories as $categoryCode => $categoryLabel)
                        <option value="{{$categoryCode}}">
                            {{$categoryLabel}}</option>
                    @endforeach
                </select>
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-2 control-label">По дням</div>
        <div class="col-sm-10">
            @foreach($weekDays as $dayCode => $dayLabel)
                <label class="checkbox-inline i-checks">
                    <input type="checkbox" name="days[{{$dayCode}}]"><i></i> {{$dayLabel}}
                </label>
            @endforeach

            @if(isset($help))
                <p class="help-block">{{$help}}</p>
            @endif
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Период</label>

        <div class="col-sm-5">
            <div class='input-group date date-picker'>
                <input type='text'  class="form-control"
                       value=""
                       placeholder=""

                       name="start-date"
                >
                    <span class="input-group-addon">
                        <span class="icon-plus"></span>
                    </span>
            </div>
        </div>

        <div class="col-sm-5">
            <div class='input-group date date-picker'>
                <input type='text'  class="form-control"
                       value=""
                       placeholder=""

                       name="end-date"
                >
                    <span class="input-group-addon">
                        <span class="icon-plus"></span>
                    </span>
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Время</label>

        <div class="col-sm-5">
            <div class='input-group date time-picker'>
                <input type='text'  class="form-control"
                       value=""
                       placeholder=""

                       name="start-time"
                >
                    <span class="input-group-addon">
                        <span class="icon-plus"></span>
                    </span>
            </div>
        </div>

        <div class="col-sm-5">
            <div class='input-group date time-picker'>
                <input type='text'  class="form-control"
                       value=""
                       placeholder=""

                       name="end-time"
                >
                    <span class="input-group-addon">
                        <span class="icon-plus"></span>
                    </span>
            </div>
        </div>
    </div>
</div>