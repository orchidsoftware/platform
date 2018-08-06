@extends('platform::layouts.dashboard')

@section('title',$name)
@section('description',$description)

@section('navbar')
    <ul class="nav justify-content-end  v-center" role="tablist">
        <li class="nav-item">
            <a href="{{ route('platform.systems.category.create')}}" class="btn btn-link">
                <i class="icon-plus"></i> {{trans('platform::common.commands.add')}}</a>
        </li>
    </ul>
@stop

@section('content')
    <!-- main content  -->
    <section>
        <div class="bg-white-only bg-auto no-border-xs">

            @empty($category->count())

                <div class="text-center bg-white app-content-center">
                    <div>
                        <h3 class="font-thin">{{trans('platform::systems/category.not_found')}}</h3>
                    </div>
                </div>

            @else

                @include('platform::container.posts.filter')

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="w-xs">{{trans('platform::common.Manage')}}</th>
                            <th>{{trans('platform::systems/category.name')}}</th>

                            @foreach($entity->grid() as $th)
                                <th width="{{$th->width}}">{{$th->title}}</th>
                            @endforeach
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($category as $item)

                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('platform.systems.category.edit',$item->id) }}">
                                        <i class="icon-menu"></i>
                                    </a>
                                </td>
                                <td>{{$item->term->getContent('name')}}</td>

                                @foreach($entity->grid() as $td)
                                    <td>
                                        @isset($td->render)
                                            {!! $td->handler($item->term) !!}
                                        @else
                                            {{ $item->term->getContent($td->name) }}
                                        @endisset
                                    </td>
                                @endforeach
                            </tr>


                            @include('platform::partials.systems.categoryItem',[
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
                                {{trans('platform::common.show')}} {{($category->currentPage()-1)*$category->perPage()+1}}
                                -
                                {{($category->currentPage()-1)*$category->perPage()+count($category->items())}} {{trans('platform::common.of')}} {!! $category->total() !!} {{trans('platform::common.elements')}}</small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                            {!! $category->links('platform::partials.pagination') !!}
                        </div>
                    </div>
                </footer>

            @endempty


        </div>
    </section>
    <!-- / main content  -->
@stop
