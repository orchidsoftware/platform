@if($filters->count() > 0)
    <div class="wrapper-md b-b">
        <div class="row">
            <div class="col-md-12">
                <button type="submit"
                        id="button-filter"
                        form="filters"
                        class="btn btn-default pull-right"><i class="fa fa-filter"></i>
                </button>
            </div>
        </div>
        <div class="row">
            @foreach($filters->chunk($chunk) as $value)
                <div class="col-sm-3">
                    @foreach($value as $filter)
                        @if(is_a($filter->display(),\Orchid\Platform\Fields\FieldContract::class))
                            {!! $filter->display()->form('filters')->render() !!}
                        @else
                            {!! $filter->display() !!}
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endif
