@if($filters->count() > 0)
    <div class="row justify-content-start" data-controller="screen--filter">
        @foreach($filters->where('display', true) as $filter)
            <div class="col-sm-auto align-self-start">
                {!! $filter->render() !!}
            </div>
        @endforeach
        <div class="col-sm-auto ml-auto align-self-end text-right">
            <div class="mb-3">
                <div class="btn-group" role="group">
                    <button
                            data-action="screen--filter#clear"
                            class="btn btn-default">
                        <i class="icon-refresh"></i>
                    </button>
                    <button type="submit"
                            form="filters"
                            class="btn btn-default">
                        <i class="icon-filter"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
