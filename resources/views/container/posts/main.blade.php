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
@section('content')
    @if($data->count() > 0)
        <section>
            <div class="bg-white-only  bg-auto no-border-xs">


                {!! $type->showFilterDashboard() !!}

                <div class="card-body row">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="w-xs">{{trans('dashboard::common.Manage')}}</th>
                                @foreach($fields as $key => $name)
                                    @if(is_array($name))
                                        <th width="{{$name['width'] or ''}}">{{$name['name']}}</th>
                                    @else
                                        <th>{{$name}}</th>
                                    @endif
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
                                    @foreach($fields as $key => $name)
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
                    <footer class="card-footer col">
                        <div class="row">
                            <div class="col-sm-5">
                                <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$data->total()}}
                                    -{{$data->perPage()}} {{trans('dashboard::common.of')}} {!! $data->count() !!} {{trans('dashboard::common.elements')}}</small>
                            </div>
                            <div class="col-sm-7 text-right text-center-xs">
                                {!! $data->appends('search')->links('dashboard::partials.pagination') !!}
                            </div>
                        </div>
                    </footer>
                </div>
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
