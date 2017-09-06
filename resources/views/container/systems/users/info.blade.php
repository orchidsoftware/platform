<div class="wrapper-md">
    <div class="bg-white">


        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label">{{trans('dashboard::systems/users.name')}}</label>
            <div class="col-sm-10">
                <input type="text" name="name" class="form-control" value="{{$user->name or old('name')}}"
                       placeholder="{{trans('dashboard::systems/users.name')}}">
            </div>
        </div>

        <div class="line line-dashed b-b line-lg"></div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label">{{trans('dashboard::systems/users.email')}}</label>
            <div class="col-sm-10">
                <input type="email" name="email" class="form-control" value="{{$user->email or old('email')}}"
                       placeholder="{{trans('dashboard::systems/users.email')}}">
            </div>
        </div>

        <div class="line line-dashed b-b line-lg"></div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label">{{trans('dashboard::systems/users.password')}}</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" value="{{old('password')}}"
                       placeholder="********">
            </div>
        </div>

        {{--
        <div class="line line-dashed b-b line-lg"></div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label">{{trans('dashboard::systems/users.confirmed_password')}}</label>
            <div class="col-sm-10">
                <input type="password" name="password_confirmation" class="form-control"
                       value="{{old('password_confirmation')}}"
                       placeholder="********">
            </div>
        </div>
        --}}

    </div>
</div>
