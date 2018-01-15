{!! $filters or '' !!}

<div class="bg-white-only  bg-auto no-border-xs">
    <div class="panel-body row">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    @foreach($form['fields'] as $key => $name)
                        @if(is_array($name))
                            <th width="{{$name['width'] or ''}}">{{$name['name']}}</th>
                        @else
                            <th>{{$name}}</th>
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($form['data'] as $key => $datum)
                    <tr>
                        @foreach($form['fields'] as $key => $name)
                            <td>
                                @if(is_array($name))
                                    {!! $name['action']($datum) !!}
                                @else
                                    {{ $datum->getContent($key) }}
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        @if(is_object($form['data']))
        <footer class="panel-footer">
            <div class="row">
                <div class="col-sm-5">
                    <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} 
					{{($form['data']->currentPage()-1)*$form['data']->perPage()+1}}-{{($form['data']->currentPage()-1)*$form['data']->perPage()+count($form['data']->items())}}
					{{trans('dashboard::common.of')}} {{$form['data']->total()}} {{trans('dashboard::common.elements')}}</small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    {!! $form['data']->appends(request()->except(['page','_token']))->links('dashboard::partials.pagination') !!}
                </div>
            </div>
        </footer>
        @endif
    </div>
</div>

