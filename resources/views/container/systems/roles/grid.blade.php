@extends('platform::layouts.dashboard')
@section('title',$name)
@section('description',$description)
@section('navbar')
    <div class="text-right">
        <div class="btn-group" role="group">
            <a href="{{ route('platform.systems.roles.create')}}" class="btn btn-link">
                <i class="icon-plus"></i> {{trans('platform::common.commands.add')}}
            </a>
        </div>
    </div>
@stop
@section('content')
    <!-- main content  -->
    <section>
        <div class="bg-white-only bg-auto no-border-xs">
            @if($roles->count() > 0)
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th class="w-xs">{{trans('platform::common.Manage')}}</th>
                            <th>{{trans('platform::systems/roles.name')}}</th>
                            <th>{{trans('platform::systems/roles.slug')}}</th>
                            <th>{{trans('platform::common.Last edit')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td class="text-center">
                                    <a href="{{ route('platform.systems.roles.edit',$role->slug) }}">
                                        <i class="icon-menu"></i>
                                    </a>
                                </td>
                                <td>{{ $role->name }}</td>
                                <td>{{ $role->slug }}</td>
                                <td>{{ $role->updated_at or $role->created_at }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <footer class="card-footer">
                    <div class="row">
                        <div class="col-sm-5">
                            <small class="text-muted inline m-t-sm m-b-sm">
                                {{trans('platform::common.show')}} {{($roles->currentPage()-1)*$roles->perPage()+1}} -
                                {{($roles->currentPage()-1)*$roles->perPage()+count($roles->items())}}
                                {{trans('platform::common.of')}}
                                {!! $roles->total() !!}
                                {{trans('platform::common.elements')}}</small>
                        </div>
                        <div class="col-sm-7 text-right text-center-xs">
                            {!! $roles->links('platform::partials.pagination') !!}
                        </div>
                    </div>
                </footer>
            @else
                <div class="text-center bg-white not-found">
                    <div>
                        <h3 class="font-thin">{{trans('platform::systems/roles.not_found')}}</h3>
                        <a href="{{ route('platform.systems.roles.create')}}"
                           class="btn btn-link">{{trans('platform::systems/roles.create')}}</a>
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!-- / main content  -->
@stop