@component('platform::partials.fields.group',get_defined_vars())

    <div data-controller="fields--utm">
        <div class="input-group mb-3">
            <input @include('platform::partials.fields.attributes', ['attributes' => $attributes]) data-target="fields--utm.url">
            <div class="input-group-append">
                <button type="button" class="btn btn-default" data-toggle="modal" data-target="#utm-{{$id}}">{{trans('platform::field.utm.Generate UTM')}}</button>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="utm-{{$id}}" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header m-b">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h5 class="modal-title" id="exampleModalLabel">{{trans('platform::field.utm.UTM Generator')}}</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('platform::field.utm.Campaign Source')}} - <span class="font-bold">utm_source</span></label>
                                    <input type="text" data-target="fields--utm.source"  placeholder="google"
                                           class="form-control">
                                    <small class="help-block w-b-k">{{trans('platform::field.utm.Campaign Source desc')}}</small>
                                </div>

                                <div class="form-group">
                                    <label>{{trans('platform::field.utm.Campaign Medium')}} - <span class="font-bold">utm_medium</span></label>
                                    <input type="text" data-target="fields--utm.medium"  placeholder="cpc" class="form-control">
                                    <small class="help-block w-b-k">{{trans('platform::field.utm.Campaign Medium desc')}}</small>
                                </div>

                                <div class="form-group">
                                    <label>{{trans('platform::field.utm.Campaign Name')}} - <span class="font-bold">utm_campaign</span></label>
                                    <input type="text" data-target="fields--utm.campaign" pattern="[a-zA-Z0-9]+"
                                           placeholder="sleeping_beds"
                                           class="form-control">
                                    <small class="help-block w-b-k">{{trans('platform::field.utm.Campaign Name desc')}}</small>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('platform::field.utm.Campaign Term')}} - <span class="font-bold">utm_term</span></label>
                                    <input type="text" data-target="fields--utm.term" placeholder="Golf ball" class="form-control">
                                    <small class="help-block w-b-k">{{trans('platform::field.utm.Campaign Term desc')}}</small>
                                </div>

                                <div class="form-group">
                                    <label>{{trans('platform::field.utm.Campaign Content')}} - <span class="font-bold">utm_content</span></label>
                                    <input type="text" data-target="fields--utm.content" placeholder="cpc" class="form-control">
                                    <small class="help-block w-b-k">{{trans('platform::field.utm.Campaign Content desc')}}
                                    </small>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{trans('platform::field.Close')}}</button>
                        <button type="button" data-action="fields--utm#generate" class="btn btn-primary">{{trans('platform::field.utm.Generate URL')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endcomponent


