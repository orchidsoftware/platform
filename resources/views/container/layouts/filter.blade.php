@if($filters->count() > 0)
    <div class="wrapper-md b-b" data-controller="screen--filter">
        <div class="row">
            <div class="col-md-12">
                <div class="btn-group pull-right" role="group">
                    <button
                            data-action="screen--filter#clear"
                            class="btn btn-default"><i class="icon-refresh"></i>
                    </button>
                    <button type="submit"
                            id="button-filter"
                            form="filters"
                            class="btn btn-default"><i class="icon-filter"></i>
                    </button>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach($filters->chunk($chunk) as $value)
                <div class="col-sm-3">
                    @foreach($value as $filter)

                        @php
                            $filter= $filter->display();
                        @endphp

                        @if(is_a($filter,\Orchid\Screen\Contracts\FieldContract::class))
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