@if($filters->count() > 0)
    <form class="wrapper-md b-b">
        <div class="row">
            <div class="col-md-12">
                <button type="submit" id="button-filter" class="btn btn-default pull-right"><i class="fa fa-filter"></i>
                </button>
            </div>
        </div>
        <div class="row">
            @foreach($filters->chunk($chunk) as $value)
                <div class="col-sm-3">
                    @foreach($value as $filter)
                        {!! $filter->display() !!}
                    @endforeach
                </div>
            @endforeach
        </div>

    </form>
@endif
