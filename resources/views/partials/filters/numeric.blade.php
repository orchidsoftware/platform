<div class="dropdown d-inline-block">
    <button class="btn btn-sm btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
        <i class="icon-filter"></i>
    </button>
    <div class="dropdown-menu">
        <form class="wrapper-sm" accept-charset="utf-8" method="get" enctype="multipart/form-data">
            <div class="form-group m-b row no-gutters">
                <select class="form-control col-3">
                  <option>=</option>
                  <option>></option>
                  <option><</option>
                </select>
                <input type="number" name="?filter[{{$th->column}}]" class="form-control form-control-sm col-9" required placeholder="{{ __('Filter') }}">
            </div>
            <div class="line line-dashed b-b line-lg"></div>
            <button type="submit" class="btn btn-default btn-sm w-full">{{__('Apply')}}</button>
        </form>
    </div>
</div>