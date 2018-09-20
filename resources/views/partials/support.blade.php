<!-- Modal Support-->
<div class="modal fade slide-up disable-scroll" id="support" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content-wrapper">
            <div class="modal-content">


                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title m-b text-black font-thin">Связаться с представителем</h4>
                </div>
                <div class="modal-body">
                    <form action="#" v-on:submit.prevent="send" method="post"
                          enctype="multipart/form-data">

                        {!! csrf_field() !!}

                        <div class="form-group mb-3">
                            <label for="username" class="control-label">{{trans('support.Name')}}</label>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <div class="form-group mb-3">
                            <label for="username" class="control-label">{{trans('support.Name')}}</label>
                            <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1">
                        </div>

                        <div class="form-group mb-3">
                            <label for="username" class="control-label">{{trans('support.Name')}}</label>

                            <textarea class="form-control no-resize" name="message" maxlength="500"
                                      required
                                      rows="8"></textarea>
                        </div>


                    </form>

                </div>

                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-8">
                            <button type="submit" class="btn btn-primary">{{trans('support.Send')}}
                                <i class="m-l-sm icon-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Modal Support-->
