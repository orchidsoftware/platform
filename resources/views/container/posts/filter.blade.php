@if($filters->count() > 0)
    <div class="wrapper-md b-b">
        <div class="row">
            @foreach($filters->chunk($chunk) as $value)
                <div class="col-sm-3">
                    @foreach($value as $filter)
                        {{$filter->display()}}
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-12">
                <button type="button" id="button-filter" class="btn btn-default pull-right"><i class="fa fa-filter"></i>
                    Фильтровать
                </button>
            </div>
        </div>
    </div>
@endif
