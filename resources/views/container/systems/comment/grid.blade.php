@extends('platform::layouts.dashboard')
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
                                    <th class="w-xs text-center">{{trans('platform::common.Manage')}}</th>
                                    <th class="w-xs text-center">{{trans('platform::systems/comment.status')}}</th>
                                    <th>{{trans('platform::systems/comment.content')}}</th>
                                    <th>Материал</th>
                                    <th>{{trans('platform::systems/comment.user')}}</th>
                                    <th>{{trans('platform::common.Last edit')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($comments as $comment)
                                    <tr>
                                        <td class="text-center">
                                            <a href="{{route('platform.systems.comment.edit',$comment->id)}}"><i
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
                                                <a href="{{ route('platform.posts.type.edit',[
                                                          $comment->post->type,
                                                          $comment->post->id
                                                ]) }}">
                                                    {{trans('platform::systems/comment.go')}}
                                                </a>
                                            @else
                                                {{trans('platform::systems/comment.delete')}}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('platform.systems.users.edit',$comment->user_id) }}">
                                                Перейти
                                            </a>
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
                                <small class="text-muted inline m-t-sm m-b-sm">
                                    {{trans('platform::common.show')}}
                                    {{($comments->currentPage()-1)*$comments->perPage()+1}} -
                                    {{($comments->currentPage()-1)*$comments->perPage()+count($comments->items())}}
                                    {{trans('platform::common.of')}}
                                    {!! $comments->total() !!}
                                    {{trans('platform::common.elements')}}
                                </small>
                            </div>
                            <div class="col-sm-7 text-right text-center-xs">
                                {!! $comments->render() !!}
                            </div>
                        </div>
                    </footer>
                </div>
            @else
                <div class="text-center bg-white app-content-center">
                    <div>
                        <h3 class="font-thin">{{trans('platform::systems/comment.not_found')}}</h3>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- / main content  -->
@stop