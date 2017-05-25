<div class="wrapper-md">
    <div class="bg-white">


        <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label">{{trans('dashboard::systems/users.roles')}}</label>
            <div class="col-sm-10">
                <select data-placeholder="{{trans('dashboard::systems/users.select_roles')}}" name="roles[]" multiple
                        class="select2 form-control w-full">
                    @foreach($roles as $role)
                        <option value="{{$role->slug}}" @if($role->active) selected @endif>{{$role->name}}</option>
                    @endforeach
                </select>

            </div>
        </div>


        <div class="line line-dashed b-b line-lg"></div>


        @foreach($permission as $name => $group)


            <span class="text-muted">{{ $name or '' }}</span>


            <div class="row padder-v">
                <div class="col-xs-12">

                    @foreach($group as $value)


                        <div class="col-xs-12 col-sm-6 col-md-4 m-t-xs m-b-xs">
                            <label class="i-checks m-b-none">
                                <input type="checkbox" name="permissions[{{$value['slug']}}]" value="1"
                                       @if(array_key_exists('active',$value) && $value['active']) checked="checked" @endif>
                                <i></i> {{$value['description']}}
                            </label>
                        </div>

                    @endforeach

                </div>
            </div>

            <div class="line line-dashed b-b line-lg"></div>


        @endforeach


    </div>
</div>
