<div class="dropdown d-inline-block">
    <button class="btn btn-sm btn-link dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
        <i class="icon-filter"></i>
    </button>
    <div class="dropdown-menu">
        <div class="wrapper-sm">
            <div class="form-group m-b">
                <input type="text" maxlength="255" required class="form-control form-control-sm" placeholder="{{ __('Filter') }}">
            </div>
            <div class="line line-dashed b-b line-lg"></div>
            <button type="submit" class="btn btn-default btn-sm w-full">{{__('Apply')}}</button>
        </div>
    </div>
</div>