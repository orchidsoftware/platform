@extends('dashboard::layouts.dashboard')

@section('title',$name)
@section('description',$description)


@section('navbar')
    <div class="text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('dashboard.systems.category.create')}}" class="btn btn-link"><i
                        class="sli icon-plus fa-2x"></i></a>
        </div>
    </div>
@stop


@section('content')
    <!-- main content  -->
    <section>
        <div class="bg-white-only bg-auto no-border-xs">

            @if($category->count() > 0)

                @include('dashboard::container.posts.filter')

                <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="w-xs">{{trans('dashboard::common.Manage')}}</th>
                                <th>{{trans('dashboard::systems/category.name')}}</th>

                                @foreach($behavior->grid() as $th)
                                    <th width="{{$th->width}}">{{$th->title}}</th>
                                @endforeach
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($category as $item)

                                <tr>
                                    <td class="text-center">
                                        <a href="{{ route('dashboard.systems.category.edit',$item->id) }}">
                                            <i class="icon-menu"></i>
                                        </a>
                                    </td>
                                    <td>{{$item->term->getContent('name')}}</td>

                                    @foreach($behavior->grid() as $td)
                                        <td>
                                            @if(!is_null($td->render))
                                                {!! $td->handler($item->term) !!}
                                            @else
                                                {{ $item->term->getContent($td->name) }}
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>


                                @include('dashboard::partials.systems.categoryItem',[
                                    'item' => $item->allChildrenTerm,
                                    'delimiter' => '- '
                                ])

                            @endforeach
                            </tbody>
                        </table>
                    </div>

                <footer class="card-footer">
                    <div class="row">
                        <div class="col-sm-5">
                            <small class="text-muted inline m-t-sm m-b-sm">
							{{trans('dashboard::common.show')}} {{($category->currentPage()-1)*$category->perPage()+1}} -
							{{($category->currentPage()-1)*$category->perPage()+count($category->items())}} {{trans('dashboard::common.of')}} {!! $category->total() !!} {{trans('dashboard::common.elements')}}</small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                            {!! $category->links('dashboard::partials.pagination') !!}
                        </div>
                    </div>
                </footer>
            @else

                <div class="jumbotron text-center bg-white not-found">
                    <div>
                        <h3 class="font-thin">{{trans('dashboard::systems/category.not_found')}}</h3>
                    </div>
                </div>

            @endif

        </div>
    </section>
    <!-- / main content  -->
@stop
