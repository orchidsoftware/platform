@extends('dashboard::layouts.dashboard')


@section('title',$type->name)
@section('description',$type->description)




@section('navbar')




    <div class="col-sm-6 col-xs-12 text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('dashboard.posts.type.create',$type->slug)}}" class="btn btn-link"><i
                        class="icon-plus fa fa-2x"></i></a>
        </div>


        <form class="navbar-form navbar-form-sm navbar-right shift" role="search">
            <div class="form-group">
                <div class="input-group">
                    <input type="text" class="form-control input-sm bg-light no-border rounded padder" name="search"
                           value="{{request('search')}}" placeholder="Поиск записей...">
                    <span class="input-group-btn">
                <button type="submit" class="btn btn-sm bg-light rounded"><i class="fa fa-search"></i></button>
              </span>
                </div>
            </div>
        </form>

    </div>
@stop


@section('content')

    @if($data->count() > 0)
        <section class="wrapper">
            <div class="bg-white-only  bg-auto no-border-xs">
                <div class="panel-body row">

                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="w-xs">{{trans('dashboard::common.Manage')}}</th>
                                @foreach($fields as $key => $name)
                                    <th>{{$name}}</th>
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
                                    }}"><i class="fa fa-bars"></i></a>
                                    </td>

                                    @foreach($fields as $key => $name)
                                        <td>
                                            {{$datum->getContent($key)}}
                                        </td>
                                    @endforeach


                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>


                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8">
                                <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$data->total()}}
                                    -{{$data->perPage()}} {{trans('dashboard::common.of')}} {!! $data->count() !!} {{trans('dashboard::common.elements')}}</small>
                            </div>
                            <div class="col-sm-4 text-right text-center-xs">
                                {!! $data->appends('search')->render() !!}
                            </div>
                        </div>
                    </footer>


                </div>
            </div>
        </section>
    @endif








@stop




