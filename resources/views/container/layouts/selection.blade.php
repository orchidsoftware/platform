<div class="" data-controller="screen--filter">
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
            <div class="col">
                @foreach($value as $filter)
                    {!! optional($filter->display())->form('filters')->render() !!}
                @endforeach
            </div>
        @endforeach
    </div>
</div>