<div class="row">
    <table class="table">
        <thead>
        <tr>
            @foreach($columns as $th)
                <th width="{{$th->width}}" class="text-{{$th->align}}">
                    <div>
                        @if($th->sort)
                            <a href="?sort={{revert_sort($th->column)}}"
                               class="@if(!is_sort($th->column)) text-muted @endif">
                                {{$th->title}}

                                @if(is_sort($th->column))
                                    <i class="icon-sort-amount-{{get_sort($th->column)}}"></i>
                                @endif
                            </a>
                        @else
                            {{$th->title}}
                        @endif


                        @includeWhen(!is_null($th->filter), "platform::partials.filters.{$th->filter}", ['th' => $th])
                    </div>

                    @if($filter = get_filter_string($th->column))
                        <div data-controller="screen--filter">
                            <a href="#"
                               data-action="screen--filter#clearFilter"
                               data-filter="{{$th->column}}"
                               class="badge badge-pill badge-light">
                                {{ $filter }}
                            </a>
                        </div>
                    @endif
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>

        @foreach($data as $key => $datum)
            <tr>
                @foreach($columns as $td)
                    <td class="text-{{$td->align}}">

                        @isset($td->render)
                            {!! $td->handler($datum) !!}
                        @else
                            {{ $datum->getContent($td->name) }}
                        @endisset
                    </td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>

    @if(
    (method_exists($data,'total') && optional($data)->total() === 0) ||
    (method_exists($data,'count') && optional($data)->count() === 0) ||
    (is_array($data) && count($data) === 0)
    )

        <div class="text-center bg-white pt-5 pb-5 w-full">
            <h3 class="font-thin">
                <i class="icon-table block m-b"></i>
                {{__('Records not found')}}
            </h3>
        </div>

    @endif

    @if($data instanceof \Illuminate\Contracts\Pagination\Paginator)
        <footer class="wrapper w-full">
            <div class="row">
                <div class="col-sm-5">
                    <small class="text-muted inline m-t-sm m-b-sm">
                        {{ __('Displayed records: :from-:to of :total',[
                            'from' => ($data->currentPage()-1)*$data->perPage()+1,
                            'to' => ($data->currentPage()-1)*$data->perPage()+count($data->items()),
                            'total' => $data->total(),
                        ]) }}
                    </small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    {!! $data->appends(request()->except(['page','_token']))->links('platform::partials.pagination') !!}
                </div>
            </div>
        </footer>
    @endif
</div>


