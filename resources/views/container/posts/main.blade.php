@extends('dashboard::layouts.dashboard')
@section('title',$type->name)
@section('description',$type->description)
@section('navbar')
    <div class="text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('dashboard.posts.type.create',$type->slug)}}" class="btn btn-link"><i
                        class="sli icon-plus fa-2x"></i></a>
        </div>
    </div>
@stop


@section('flash_notification.sub_message')
    @if(session('restore'))
        @include('dashboard::container.posts.restore')
    @endif
@stop


@section('content')

    @if($data->count() > 0)
        <section>
            <div class="bg-white-only  bg-auto no-border-xs">


                {!! $type->showFilterDashboard() !!}

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="w-xs">{{trans('dashboard::common.Manage')}}</th>
                            @foreach($fields as $th)
                                    <th width="{{$th->width}}">{{$th->title}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($data as $key => $datum)
                            <tr>
                                <td class="text-center">
                                    <a href="{{route('dashboard.posts.type.edit',[
                                'type' => $type->slug,
                                'slug' => $datum->id])
                                }}"><i class="icon-menu"></i></a>
                                </td>
                                @foreach($fields as $td)
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
                <footer class="card-footer col">
                    <div class="row">
                        <div class="col-sm-5">
                            <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{($data->currentPage()-1)*$data->perPage()+1}} -
							{{($data->currentPage()-1)*$data->perPage()+count($data->items())}} {{trans('dashboard::common.of')}} {!! $data->total() !!} {{trans('dashboard::common.elements')}}</small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                            {!! $data->appends('search')->links('dashboard::partials.pagination') !!}
                        </div>
                    </div>
                </footer>
            </div>
        </section>
    @else
        <section>
            <div class="bg-white-only bg-auto no-border-xs">


                {!! $type->showFilterDashboard() !!}


                <div class="jumbotron text-center bg-white not-found">
                    <div>
                        <h3 class="font-thin">{{trans('dashboard::post/base.not_found')}}</h3>
                        <a href="{{ route('dashboard.posts.type.create',$type->slug)}}"
                           class="btn btn-link">{{trans('dashboard::post/base.create')}}</a>
                    </div>
                </div>
            </div>
        </section>
    @endif
@stop
