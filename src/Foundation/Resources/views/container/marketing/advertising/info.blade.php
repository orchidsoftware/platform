<div class="wrapper-md">

    <div class="form-group m-t-md">
        <label class="col-sm-2 control-label">Имя</label>
        <div class="col-sm-10">
            <input type="text" name="slug" required class="form-control"
                  value="{{$adv->slug}}">
        </div>
    </div>

    <div class="line line-dashed b-b line-lg"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Категория</label>
        <div class="col-sm-10">
            <select required data-placeholder="Select Category" name="category_id" class="chosen-select form-control">
                @foreach($categories as $categoryCode => $categoryLabel)
                    <option value="{{$categoryCode}}"
                            @if($adv->getContent('category') == $categoryCode) selected @endif>
                        {{$categoryLabel}}</option>
                @endforeach
            </select>
        </div>
    </div>


    <div class="line line-dashed b-b line-lg"></div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Период</label>

        <div class="col-sm-5">
            <div class="input-group">
                <input required type='text' class="form-control datetimepicker"
                        value="{{$adv->getContent('start-date')}}"
                       placeholder=""

                       name="start-date"
                >
                <span class="input-group-addon">
                        <span class="fa fa-calendar" aria-hidden="true"></span>
                    </span>
            </div>
        </div>

        <div class="col-sm-5">
            <div class="input-group">
                <input required type='text' class="form-control datetimepicker"
                        value="{{$adv->getContent('end-date')}}"
                       placeholder=""

                       name="end-date"
                >
                <span class="input-group-addon">
                        <span class="fa fa-calendar" aria-hidden="true"></span>
                    </span>
            </div>
        </div>
    </div>



</div>



