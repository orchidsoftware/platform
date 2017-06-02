<div class="dropzone" id="real-dropzone">
    <div class="fallback">
        <input type="file" value="" multiple/>
    </div>
    <div class="visual-dropzone sortable-dropzone dropzone-previews">
    </div>
    <div class="dz-message">
        <hr>
        <p class="font-bold">{{trans('dashboard::post/post.upload.title')}}</p>
        <small>{{trans('dashboard::post/post.upload.description')}}</small>
    </div>
</div>


<div class="modal fade slide-up disable-scroll" id="modalAttachment" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content-wrapper">
            <div class="modal-content">
                <div class="modal-header clearfix text-left">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-times"></i>
                    </button>
                    <h5>{{trans('dashboard::post/post.upload.information.title')}}</h5>
                    <p class="m-b-md">{{trans('dashboard::post/post.upload.information.sub_title')}}</p>
                </div>
                <div class="modal-body" v-if="active != null">
                    <div class="row">
                        <div class="col-sm-10 col-sm-offset-1">
                            <div class="wrapper">

                                <div class="form-group">
                                    <label>{{trans('dashboard::post/post.upload.information.system_name')}}</label>
                                    <input type="text" class="form-control" v-model="attachment[active].name" readonly
                                           maxlength="255"
                                           placeholder="{{trans('dashboard::post/post.upload.information.system_name')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{trans('dashboard::post/post.upload.information.name')}}</label>
                                    <input type="text" class="form-control" v-model="attachment[active].original_name"
                                           maxlength="255"
                                           placeholder="{{trans('dashboard::post/post.upload.information.name')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{trans('dashboard::post/post.upload.information.alt')}}</label>
                                    <input type="text" class="form-control" v-model="attachment[active].alt"
                                           maxlength="255"
                                           placeholder="{{trans('dashboard::post/post.upload.information.alt')}}">
                                </div>
                                <div class="form-group">
                                    <label>{{trans('dashboard::post/post.upload.information.description')}}</label>
                                    <textarea class="form-control no-resize" v-model="attachment[active].description"
                                              placeholder="{{trans('dashboard::post/post.upload.information.description')}}"
                                              maxlength="255"
                                              rows="3"></textarea>
                                </div>

                                <p class="text-right">
                                    <button type="button" v-on:click="save"
                                            class="btn btn-default">{{trans('dashboard::common.Apply')}}</button>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
