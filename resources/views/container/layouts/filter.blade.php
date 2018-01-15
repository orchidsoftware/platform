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

                        @php
                            $filter= $filter->display();
                        @endphp

                        @if(is_a($filter,\Orchid\Platform\Fields\FieldContract::class))
                            {!! $filter->form('filters')->render() !!}
                        @else
                            {!! $filter !!}
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
@endif
