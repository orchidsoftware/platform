<footer class="wrapper w-full">
    <div class="row">
        <div class="col-sm-5">
            @if($paginator instanceof \Illuminate\Contracts\Pagination\LengthAwarePaginator)
                <small class="text-muted inline m-t-sm m-b-sm">
                    {{ __('Displayed records: :from-:to of :total',[
                        'from' => ($paginator->currentPage() -1 ) * $paginator->perPage() + 1,
                        'to' => ($paginator->currentPage() -1 ) * $paginator->perPage() + count($paginator->items()),
                        'total' => $paginator->total(),
                    ]) }}
                </small>
            @endif
        </div>
        <div class="col-sm-7 text-right text-center-xs">
            {!! $paginator->appends(request()->except(['page','_token']))->links('platform::partials.pagination') !!}
        </div>
    </div>
</footer>
