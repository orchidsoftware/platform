<div class="wrapper-md">
    <div class="bg-white padder-md">


        <div class="form-group{{ $errors->has('roles') ? ' has-error' : '' }}">
            <label class="control-label">{{trans('dashboard::systems/users.roles')}}</label>

            <select data-placeholder="{{trans('dashboard::systems/users.select_roles')}}" name="roles[]" multiple
                    class="select2 form-control w-full">
                @foreach($roles as $role)
                    <option value="{{$role->slug}}" @if($role->active) selected @endif>{{$role->name}}</option>
                @endforeach
            </select>
        </div>


        @foreach($permission as $name => $group)

            @if(count($group) == 0)
                @continue
            @endif


            <div class="line line-dashed b-b line-lg"></div>

            <span class="text-muted">{{ $name or '' }}</span>

            <div class="row padder-v mx-0">
                <div class="col row">

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

        @endforeach


    </div>
</div>
