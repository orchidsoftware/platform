@extends('dashboard::layouts.dashboard')


@section('title',$name)
@section('description',$description)



@section('content')


    <!-- main content  -->
    <section>
        <div class="bg-white-only bg-auto no-border-xs">

            @if($comments->count() > 0)
                <div class="card">

                    <div class="card-body row">


                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="w-xs text-center">{{trans('dashboard::common.Manage')}}</th>
                                    <th class="w-xs text-center">{{trans('dashboard::systems/comment.status')}}</th>
                                    <th>{{trans('dashboard::systems/comment.content')}}</th>
                                    <th>Материал</th>
                                    <th>{{trans('dashboard::systems/comment.user')}}</th>
                                    <th>{{trans('dashboard::common.Last edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($comments as $comment)

                                    <tr>
                                        <td class="text-center">
                                            <a href="{{route('dashboard.systems.comment.edit',$comment->id)}}"><i
                                                        class="icon-menu"></i></a>
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
                                        ]) }}">{{trans('dashboard::systems/comment.go')}}</a>
                                            @else
                                                {{trans('dashboard::systems/comment.delete')}}
                                            @endif
                                        </td>

                                        <td><a href="{{ route('dashboard.systems.users.edit',$comment->user_id) }}">Перейти</a>
                                        </td>
                                        <td>{{ $comment->updated_at}}</td>
                                    </tr>

                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>

                    <footer class="card-footer">
                        <div class="row">
                            <div class="col-sm-5">
                                <small class="text-muted inline m-t-sm m-b-sm">{{trans('dashboard::common.show')}} {{($comments->currentPage()-1)*$comments->perPage()+1}} -
							{{($comments->currentPage()-1)*$comments->perPage()+count($comments->items())}} {{trans('dashboard::common.of')}} {!! $comments->total() !!} {{trans('dashboard::common.elements')}}</small>
                            </div>
                            <div class="col-sm-7 text-right text-center-xs">
                                {!! $comments->render() !!}
                            </div>
                        </div>
                    </footer>
                </div>

            @else

                <div class="jumbotron text-center bg-white not-found">
                    <div>
                        <h3 class="font-thin">{{trans('dashboard::systems/comment.not_found')}}</h3>
                    </div>
                </div>

            @endif

        </div>
    </section>
    <!-- / main content  -->


@stop




