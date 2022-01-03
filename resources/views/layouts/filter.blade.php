@if ($filters->count() > 0)
    <div class="g-0 bg-white rounded mb-3">
        <div class="row align-items-center p-4" data-controller="filter">
            @foreach ($filters->where('display', true) as $filter)
                <div class="col-sm-auto col-md mb-3 align-self-start" style="min-width: 200px;">
                    {!! $filter->render() !!}
                </div>
            @endforeach
            <div class="col-sm-auto ms-auto text-end">
                <div class="btn-group" role="group">
                    <button data-action="filter#clear" class="btn btn-default">
                        <x-orchid-icon class="me-1" path="refresh" /> {{ __('Reset') }}
                    </button>
                    <button type="submit" form="filters" class="btn btn-default">
                        <x-orchid-icon class="me-1" path="filter" /> {{ __('Apply') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
@endif
