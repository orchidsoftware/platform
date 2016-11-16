<div class="wrapper-md">
    <div class="bg-white">
        <form class="form-horizontal" action="{{route('dashboard.systems.roles')}}" method="post">



            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="col-lg-2 control-label">Название</label>

                <div class="col-lg-10">
                    <input type="text" name="name" class="form-control" value="{{$role->name or ''}}">
                    <small class="help-block m-b-none">Отображаемое имя роли пользователя
                    </small>
                </div>
            </div>

            <div class="line line-dashed b-b line-lg"></div>

            <div class="form-group{{ $errors->has('slug') ? ' has-error' : '' }}">
                <label class="col-lg-2 control-label">Ссылка</label>

                <div class="col-lg-10">
                    <input type="text" class="form-control" name="slug" value="{{$role->slug or ''}}">
                    <small class="help-block m-b-none">Фактическое название в системе</small>
                </div>
            </div>


            @foreach($permission as $name => $group)


                <div class="line line-dashed b-b line-lg"></div>

                <span class="text-muted">{{ $name or '' }}</span>


                <div class="row padder-v">
                    <div class="col-xs-12">

                        @foreach($group as $value)


                            <div class="col-xs-12 col-sm-6 col-md-4">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox" name="permissions[{{$value['slug']}}]" value="1"
                                    @if(array_key_exists('active',$value) && $value['active']) checked="checked" @endif>
                                    <i></i> {{$value['description']}}
                                </label>
                            </div>

                        @endforeach

                    </div>
                </div>


            @endforeach


            <div class="form-group text-center">
                <div class="col-md-4 col-md-offset-8">

                    {!! csrf_field() !!}

                    <button type="submit" class="btn btn-sm btn-info">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>