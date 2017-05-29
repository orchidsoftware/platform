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

        {{--
            <div  class="line line-dashed b-b line-lg"></div>
            <div  class="form-group{{ $errors->has('nickname') ? ' has-error' : '' }}">
                <label class="col-sm-2 control-label">NickName</label>
                <div  class="col-sm-10">
                    <input type="text" name="nickname" class="form-control" value="{{$user->nickname or old('nickname')}}"
                           placeholder="NickName">
                </div>
            </div>

            <div  class="line line-dashed b-b line-lg"></div>
            <div  class="form-group{{ $errors->has('website') ? ' has-error' : '' }}">
                <label class="col-sm-2 control-label">WebSite</label>
                <div  class="col-sm-10">
                    <input type="url" name="website" class="form-control" value="{{$user->website or old('website')}}"
                           placeholder="Web Site">
                </div>
            </div>


            <div  class="line line-dashed b-b line-lg"></div>
            <div  class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                <label class="col-sm-2 control-label">Phone</label>
                <div  class="col-sm-10">
                    <input type="tel" name="phone" class="form-control" value="{{$user->phone or old('phone')}}" placeholder="Phone">
                </div>
            </div>

            <div  class="line line-dashed b-b line-lg"></div>

            <div  class="form-group{{ $errors->has('about') ? ' has-error' : '' }}">
                <label class="col-sm-2 control-label">About</label>
                <div  class="col-sm-10">
                    <textarea class="form-control no-resize" rows="6" name="about"
                              placeholder="About">{{$user->about or old('about')}}</textarea>
                </div>
            </div>
--}}


        <div class="line line-dashed b-b line-lg"></div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label">{{trans('dashboard::systems/users.password')}}</label>
            <div class="col-sm-10">
                <input type="password" name="password" class="form-control" value="{{old('password')}}"
                       placeholder="********">
            </div>
        </div>


        <div class="line line-dashed b-b line-lg"></div>
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            <label class="col-sm-2 control-label">{{trans('dashboard::systems/users.confirmed_password')}}</label>
            <div class="col-sm-10">
                <input type="password" name="password_confirmation" class="form-control"
                       value="{{old('password_confirmation')}}"
                       placeholder="********">
            </div>
        </div>


        {{--
                <div  class="line line-dashed b-b line-lg"></div>
                    <div  class="form-group{{ $errors->has('sex') ? ' has-error' : '' }}">
                        <div  class="col-sm-offset-2 col-sm-10">
                            <label class="i-checks i-checks-sm">
                                <input type="radio" name="sex" value="1" @if($user->sex or old('sex')) checked @endif>
                                <i></i>
                                Man
                            </label>

                            <label class="i-checks i-checks-sm">
                                <input type="radio" name="sex" value="0" @if(!$user->sex or old('sex')) checked @endif>
                                <i></i>
                                Woman
                            </label>

                        </div>
                    </div>





                <div  class="line line-dashed b-b line-lg"></div>
                    <div  class="form-group{{ $errors->has('subscription') ? ' has-error' : '' }}">
                        <div  class="col-sm-offset-2 col-sm-10">
                            <label class="i-checks i-checks-sm">
                                <input type="radio" name="notification" value="1" @if($user->subscription or old('subscription')) checked @endif>
                                <i></i>
                                Subscrible
                            </label>

                            <label class="i-checks i-checks-sm">
                                <input type="radio" name="notification" value="0" @if(!$user->subscription or old('subscription')) checked @endif>
                                <i></i>
                                Non subscrible
                            </label>

                        </div>
                    </div>
        --}}

    </div>
</div>
