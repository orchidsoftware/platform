<div class="bg-white-only  bg-auto no-border-xs">

    {!! $filters or '' !!}

    @if(count($form['data']) > 0)

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    @foreach($form['fields'] as $th)
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
                @foreach($form['data'] as $key => $datum)
                    <tr>
                        @foreach($form['fields'] as $td)
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
        </div>
        @if(is_object($form['data']) && ($form['data'] instanceof \Illuminate\Contracts\Pagination\Paginator))
            <footer class="card-footer col">
                <div class="row">
                    <div class="col-sm-5">
                        <small class="text-muted inline m-t-sm m-b-sm">{{trans('platform::common.show')}}
                            {{($form['data']->currentPage()-1)*$form['data']->perPage()+1}}
                            -{{($form['data']->currentPage()-1)*$form['data']->perPage()+count($form['data']->items())}}
                            {{trans('platform::common.of')}} {{$form['data']->total()}} {{trans('platform::common.elements')}}</small>
                    </div>
                    <div class="col-sm-7 text-right text-center-xs">
                        {!! $form['data']->appends(request()->except(['page','_token']))->links('platform::partials.pagination') !!}
                    </div>
                </div>
            </footer>
        @endif

    @else

        <div class="text-center bg-white app-content-center">
            <div>
                <h3 class="font-thin">{{trans('platform::common.screen.Records not found')}}</h3>
                {{--
                Нужно как-то плучить роут
                <a href="{{ route('platform.systems.roles.create')}}"
                   class="btn btn-link">{{trans('platform::systems/roles.create')}}</a>
                --}}
            </div>
        </div>

    @endif

</div>

