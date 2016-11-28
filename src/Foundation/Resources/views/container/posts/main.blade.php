@extends('dashboard::layouts.dashboard')


@section('title',$type->name)




@section('content')



    <!-- main header -->
    <div class="bg-light lter b-b wrapper-md">
        <div class="row">
            <div class="col-sm-6 col-xs-12">
                <h1 class="m-n font-thin h3 text-black">{{$type->name or '' }}</h1>
                <small class="text-muted">Welcome to angulr application</small>
            </div>

            <div class="col-sm-6 col-xs-12 text-right">
                <div class="btn-group" role="group">
                    <a href="{{ route('dashboard.posts.type.create',$type->slug)}}" class="btn btn-link"><i class="ion-ios-plus-outline fa fa-2x"></i></a>
                </div>
            </div>

        </div>
    </div>
    <!-- / main header -->




    <section class="bg-white-only b-l bg-auto no-border-xs">
        <div class="panel-body row">
            @if($data->count() > 0)
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
            @endif
        </div>
    </section>








@stop




