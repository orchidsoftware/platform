<div class="bg-white-only  bg-auto no-border-xs">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
            <tr>
                @foreach($form['fields'] as $th)
                    <th width="{{$th->width}}" class="">
                        @if($th->sort)
                            <a href="?sort={{revert_sort($th->name)}}">
                                {{$th->title}}

                                @if(is_sort($th->name))
                                    @if(get_sort($th->name) == 'asc')
                                        <i class="icon-sort-amount-asc"></i>
                                    @else
                                        <i class="icon-sort-amount-desc"></i>
                                    @endif
                                @endif
                            </a>
                        @else
                                {{$th->title}}
                        @endif
                    </th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @foreach($form['data'] as $key => $datum)
                <tr>
                    @foreach($form['fields'] as $td)
                        <td>
                            @if(!is_null($td->render))
                                {!! $td->handler($datum) !!}
                            @else
                                {{ $datum->getContent($td->name) }}
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @if(is_object($form['data']))
        <footer class="card-footer col">
            <div class="row">
                <div class="col-sm-5">
                    <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}}
                        {{($form['data']->currentPage()-1)*$form['data']->perPage()+1}}
                        -{{($form['data']->currentPage()-1)*$form['data']->perPage()+count($form['data']->items())}}
                        {{trans('dashboard::common.of')}} {{$form['data']->total()}} {{trans('dashboard::common.elements')}}</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    {!! $form['data']->appends(request()->except(['page','_token']))->links('dashboard::partials.pagination') !!}
                </div>
            </div>
        </footer>
    @endif
</div>

