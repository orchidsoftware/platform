<div class="wrapper-md">
    <div class="bg-white padder-md">


        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="control-label">{{trans('dashboard::systems/users.name')}}</label>
            <input type="text" name="name" class="form-control" value="{{$user->name or old('name')}}"
                   placeholder="{{trans('dashboard::systems/users.name')}}">
        </div>

        <div class="line line-dashed b-b line-lg"></div>
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="control-label">{{trans('dashboard::systems/users.email')}}</label>
            <input type="email" name="email" class="form-control" value="{{$user->email or old('email')}}"
                   placeholder="{{trans('dashboard::systems/users.email')}}">
        </div>

        <div class="line line-dashed b-b line-lg"></div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="control-label">{{trans('dashboard::systems/users.password')}}</label>
            <input type="password" name="password" class="form-control" value="{{old('password')}}"
                   placeholder="********">
        </div>

    </div>
</div>
