@extends('dashboard::layouts.dashboard')


@section('title',$name)
@section('description',$description)



@section('content')


    <!-- main content -->
    <section class="wrapper">
        <div class="bg-white-only bg-auto no-border-xs">

            @if($comments->count() > 0)
                <div class="panel">

                    <div class="panel-body row">


                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="w-xs text-center">{{trans('dashboard::common.Manage')}}</th>
                                    <th class="w-xs text-center">Статус</th>
                                    <th>Содержание</th>
                                    <th>Материал</th>
                                    <th>Пользователь</th>
                                    <th>{{trans('dashboard::common.Last edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($comments as $comment)

                                    <tr>
                                        <td class="text-center">
                                            <a href="{{route('dashboard.marketing.comment.edit',$comment->id)}}"><i
                                                        class="fa fa-bars"></i></a>
                                        </td>

                                        <td class="text-center">
                                            @if($comment->isApproved())
                                                <i class="icon-check"></i>
                                            @else
                                                <i class="icon-close"></i>
                                            @endif
                                        </td>


                                        <td>{{ \Illuminate\Support\Str::limit($comment->content) }}</td>


                                        <td>
                                            @if(!is_null($comment->post))
                                            <a href="{{ route('dashboard.posts.type.edit',[
                                            $comment->post->type,
                                            $comment->post->id
                                        ]) }}">Перейти</a>
                                                @else
                                                Запись удалена
                                            @endif
                                        </td>

                                        <td><a href="{{ route('dashboard.systems.users.edit',$comment->user_id) }}">Перейти</a></td>
                                        <td>{{ $comment->updated_at}}</td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <footer class="panel-footer">
                        <div class="row">
                            <div class="col-sm-8">
                                <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{$comments->total()}}
                                    -{{$comments->perPage()}} {{trans('dashboard::common.of')}} {!! $comments->count() !!} {{trans('dashboard::common.elements')}}</small>
                            </div>
                            <div class="col-sm-4 text-right text-center-xs">
                                {!! $comments->render() !!}
                            </div>
                        </div>
                    </footer>
                </div>

            @else

                <div class="jumbotron text-center">
                    <h3 class="font-thin">Пока не было создано ни одного комментария</h3>
                </div>

            @endif

        </div>
    </section>
    <!-- / main content -->


@stop




