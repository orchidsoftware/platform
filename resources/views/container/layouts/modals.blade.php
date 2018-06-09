@section('modals-container')

    @foreach($manyForms as $key => $modal)

        <div class="modal fade in" id="screen-modal-{{$key}}" role="dialog" aria-labelledby="screen-modal-{{$key}}">
            <div class="modal-dialog" role="document" id="screen-modal-type-{{$key}}">
                <form class="modal-content" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="title-modal-{{$key}}"></h4>
                    </div>
                    <div class="modal-body">
                        @foreach($modal as $item)

                            <div data-controller="layouts-loader"
                                 data-layouts-loader-slug="{{$templateSlug}}"
                                 data-layouts-loader-async="{{$templateAsync}}"
                                 data-layouts-loader-url="Указать адрес">
                            {!! $item or '' !!}
                            </div>
                        @endforeach

                        @csrf
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit-modal-{{$key}}"
                                class="btn btn-primary">{{trans('platform::common.apply')}}</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach


@endsection
