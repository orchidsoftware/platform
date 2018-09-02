@component('platform::partials.fields.group',get_defined_vars())
    <div data-controller="fields--picture"
         data-fields--picture-image="{{$attributes['value']}}"
         data-fields--picture-width="{{$width}}"
         data-fields--picture-height="{{$height}}">
        <div class="b text-center wrapper-lg picture-actions">

            <div class="fields--picture-container m-b-md">
                <img src="#" class="picture-preview img-fluid img-thumbnail" alt="">
            </div>

            <label class="btn btn-link">
                <i class="icon-cloud-upload"></i> {{trans('platform::field.picture.Browse')}}
                <input type="file"
                       accept="image/*"
                       data-target="fields--picture.upload"
                       data-action="fields--picture#upload"
                       class="d-none">
            </label>

            <button type="button" class="btn btn-danger picture-remove"
                    data-action="fields--picture#clear">{{trans('platform::field.picture.Remove')}}</button>

            <input type="file" class="d-none">
        </div>

        <input class="picture-path"
               type="hidden"
               data-target="fields--picture.source"
                @include('platform::partials.fields.attributes', ['attributes' => $attributes])
        >

        <div class="modal" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content-wrapper">
                    <div class="modal-content">
                        <div class="modal-header clearfix">
                            <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span
                                        aria-hidden="true">×</span></button>
                            <h5>{{trans('platform::field.picture.Crop image')}}</h5>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <img class="upload-panel">
                            </div>
                            <div class="col-4">
                                <div class="preview"></div>
                                <div class="docs-data">
                                    <div class="input-group input-group-sm">
                                    <span class="input-group-prepend">
                                      <label class="input-group-text">X</label>
                                    </span>
                                        <input type="text" class="form-control picture-datas picture-dataX"
                                               placeholder="x">
                                        <span class="input-group-append">
                                      <span class="input-group-text">px</span>
                                    </span>
                                    </div>
                                    <div class="input-group input-group-sm">
                                    <span class="input-group-prepend">
                                      <label class="input-group-text">Y</label>
                                    </span>
                                        <input type="text" class="form-control picture-datas picture-dataY"
                                               placeholder="y">
                                        <span class="input-group-append">
                                      <span class="input-group-text">px</span>
                                    </span>
                                    </div>
                                    <div class="input-group input-group-sm">
                                    <span class="input-group-prepend">
                                      <label class="input-group-text">Width</label>
                                    </span>
                                        <input type="text" class="form-control picture-datas picture-dataWidth"
                                               placeholder="width">
                                        <span class="input-group-append">
                                      <span class="input-group-text">px</span>
                                    </span>
                                    </div>
                                    <div class="input-group input-group-sm">
                                    <span class="input-group-prepend">
                                      <label class="input-group-text">Height</label>
                                    </span>
                                        <input type="text" class="form-control picture-datas picture-dataHeight"
                                               placeholder="height">
                                        <span class="input-group-append">
                                      <span class="input-group-text">px</span>
                                    </span>
                                    </div>
                                    <div class="input-group input-group-sm">
                                    <span class="input-group-prepend">
                                      <label class="input-group-text">Rotate</label>
                                    </span>
                                        <input type="text" class="form-control picture-datas picture-dataRotate"
                                               placeholder="rotate">
                                        <span class="input-group-append">
                                      <span class="input-group-text">deg</span>
                                    </span>
                                    </div>
                                    <div class="input-group input-group-sm">
                                    <span class="input-group-prepend">
                                      <label class="input-group-text">ScaleX</label>
                                    </span>
                                        <input type="text" class="form-control picture-datas picture-dataScaleX"
                                               placeholder="scaleX">
                                    </div>
                                    <div class="input-group input-group-sm">
                                    <span class="input-group-prepend">
                                      <label class="input-group-text">ScaleY</label>
                                    </span>
                                        <input type="text" class="form-control picture-datas picture-dataScaleY"
                                               placeholder="scaleY">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" data-action="fields--picture#zoomin"
                                        title="Zoom In">
                                    <i class="icon-magnifier-add icons"></i>
                                </button>
                                <button type="button" class="btn btn-primary" data-action="fields--picture#zoomout"
                                        title="Zoom Out">
                                    <i class="icon-magnifier-remove icons"></i>
                                </button>
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" data-action="fields--picture#moveleft"
                                        title="Move Left">
                                    <i class="icon-arrow-left icons"></i>
                                </button>
                                <button type="button" class="btn btn-primary" data-action="fields--picture#moveright"
                                        title="Move Right">
                                    <i class="icon-arrow-right icons"></i>
                                </button>
                                <button type="button" class="btn btn-primary" data-action="fields--picture#moveup"
                                        title="Move Up">
                                    <i class="icon-arrow-up icons"></i>
                                </button>
                                <button type="button" class="btn btn-primary" data-action="fields--picture#movedown"
                                        title="Move Down">
                                    <i class="icon-arrow-down icons"></i>
                                </button>
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" data-action="fields--picture#rotateleft"
                                        title="Rotate Left">
                                    <i class="icon-action-undo icons"></i>
                                </button>
                                <button type="button" class="btn btn-primary" data-action="fields--picture#rotateright"
                                        title="Rotate Right">
                                    <i class="icon-action-redo icons"></i>
                                </button>
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" data-action="fields--picture#scalex"
                                        title="Flip Horizontal">
                                    <i class="icon-arrow-left-circle icons"></i>
                                </button>
                                <button type="button" class="btn btn-primary" data-action="fields--picture#scaley"
                                        title="Flip Vertical">
                                    <i class="icon-arrow-up-circle icons"></i>
                                </button>
                            </div>

                            <div class="btn-group">
                                <button type="button" class="btn btn-primary" data-action="fields--picture#aspectratiowh"
                                        title="Aspect Ratio Width/Height ">
                                    W:H
                                </button>
                                <button type="button" class="btn btn-primary" data-action="fields--picture#aspectratiofree"
                                        title="Free Aspect Ratio">
                                    Free
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary"
                                    data-action="fields--picture#crop">{{trans('platform::field.picture.Crop')}}</button>
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{{trans('platform::field.Close')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endcomponent