<div class="card m-b">

    {!! $filters ?? '' !!}

    @if(optional($data)->total() === 0 || count($data) === 0)

        <div class="text-center bg-white app-content-center">
            <div>
                <h3 class="font-thin">
                    <i class="icon-table block m-b"></i>
                    {{trans('platform::common.screen.Records not found')}}
                </h3>
            </div>
        </div>

    @else


        <table class="table">
                <thead>
                <tr>
                    @foreach($fields as $th)
                        <th width="{{$th->width}}" class="text-{{$th->align}}">
                            @if($th->sort)
                                <a href="?sort={{revert_sort($th->column)}}"
                                   class="@if(!is_sort($th->column)) text-muted @endif">
                                    {{$th->title}}

                                    @if(is_sort($th->column))
                                        @if(get_sort($th->column) == 'asc')
                                            <i class="icon-sort-amount-asc"></i>
                                        @else
                                            <i class="icon-sort-amount-desc"></i>
                                        @endif
                                    @endif
                                </a>
                            @else
                                {{$th->title}}
                            @endif


                            @isset($th->filter)
                                @includeIf("platform::partials.filters.{$th->filter}",[
                                    'th' => $th
                                ])
                            @endisset

                        </th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($data as $key => $datum)
                    <tr>
                        @foreach($fields as $td)
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

        @if(is_object($data) && ($data instanceof \Illuminate\Contracts\Pagination\Paginator))
            <footer class="wrapper">
                <div class="row">
                    <div class="col-sm-5">
                        <small class="text-muted inline m-t-sm m-b-sm">{{trans('platform::common.show')}}
                            {{($data->currentPage()-1)*$data->perPage()+1}}
                            -{{($data->currentPage()-1)*$data->perPage()+count($data->items())}}
                            {{trans('platform::common.of')}} {{$data->total()}} {{trans('platform::common.elements')}}</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        {!! $data->appends(request()->except(['page','_token']))->links('platform::partials.pagination') !!}
                    </div>
                </div>
            </footer>
        @endif


    @endif


</div>

