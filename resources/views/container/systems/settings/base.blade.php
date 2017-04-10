<div class="wrapper-md">
    <div class="bg-white">


        <div class="form-group">
            <label class="col-lg-2 control-label">{{trans('dashboard::systems/settings.title')}}</label>

            <div class="col-lg-10">
                <input type="text" class="form-control" name="site_title" required value="{{$site_title or '' }}">
                <small class="help-block m-b-none">{{trans('dashboard::systems/settings.default')}}
                </small>
            </div>
        </div>


        <div class="line line-dashed b-b line-lg"></div>

        <div class="form-group">
            <label class="col-lg-2 control-label">{{trans('dashboard::systems/settings.keywords')}}</label>

            <div class="col-lg-10">
                <input type="text" data-role="tagsinput" class="form-control" required name="site_keywords"
                       value="{{$site_keywords or '' }}">
                <small class="help-block m-b-none">{{trans('dashboard::systems/settings.default')}}
                </small>
            </div>
        </div>


        <div class="line line-dashed b-b line-lg"></div>


        <div class="form-group">
            <label class="col-lg-2 control-label">{{trans('dashboard::systems/settings.description')}}</label>

            <div class="col-lg-10">
                <textarea class="form-control no-resize" required name="site_description"
                          rows="4">{{$site_description or ''}}</textarea>
                <small class="help-block m-b-none">{{trans('dashboard::systems/settings.description-help')}}
                </small>
            </div>
        </div>

        <div class="line line-dashed b-b line-lg"></div>

        <div class="form-group">
            <label class="col-lg-2 control-label">{{trans('dashboard::systems/settings.address')}}</label>

            <div class="col-lg-10">
                <input type="text" class="form-control" required name="site_adress" value="{{$site_adress or '' }}">
                <small class="help-block m-b-none">{{trans('dashboard::systems/settings.address-help')}}</small>
            </div>
        </div>


        <div class="line line-dashed b-b line-lg"></div>

        <div class="form-group">
            <label class="col-lg-2 control-label">{{trans('dashboard::systems/settings.phone')}}</label>

            <div class="col-lg-10">
                <input type="text" class="form-control" required name="site_phone" value="{{ $site_phone or '' }}">
            </div>
        </div>


        <div class="line line-dashed b-b line-lg"></div>

        <div class="form-group">
            <label class="col-lg-2 control-label">{{trans('dashboard::systems/settings.email')}}</label>

            <div class="col-lg-10">
                <input type="email" class="form-control" name="site_email" required value="{{ $site_email or '' }}">
                <small class="help-block m-b-none">{{trans('dashboard::systems/settings.email-help')}}
                </small>
            </div>
        </div>

    </div>
</div>
