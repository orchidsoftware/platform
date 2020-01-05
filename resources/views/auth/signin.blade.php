<div class="form-group">
    <label class="form-label">{{__('Email address')}}</label>
    <input class="form-control @error('email') is-invalid @enderror" type="email" name="email" required
           value="{{ old('email') }}"
           placeholder="{{__('Enter your email')}}">
    @error('email')
        <span class="invalid-feedback text-danger">
            {{ $errors->first('email') }}
        </span>
    @enderror
</div>

<div class="form-group">
    <label class="form-label w-full">
        {{__('Password')}}
        <a href="{{ route('platform.password.request') }}" class="float-right small">{{__('Forgot your password?')}}</a>
    </label>

    <div data-controller="fields--password"
         class="input-icon"
    >
    <input type="password" class="form-control @error('password') is-invalid @enderror"
           name="password"
           data-target="fields--password.password"
           value="{{ old('password') }}"
           placeholder="{{__('Enter your password')}}" required>
        <div class="input-icon-addon cursor" data-action="click->fields--password#change">
            <i class="icon-eye" data-target="fields--password.icon"></i>
        </div>
    </div>
    @error('password')
        <span class="invalid-feedback text-danger">
            {{ $errors->first('password') }}
        </span>
    @enderror

</div>

<div class="row">
    <div class="form-group col-md-6 col-xs-12">
        <label class="custom-control custom-checkbox">
            <input type="checkbox" name="remember" class="custom-control-input" {{ old('remember') ? 'checked' : '' }}>
            <span class="custom-control-label"> {{__('Remember Me')}}</span>
        </label>
    </div>
    <div class="form-group col-md-6 col-xs-12">
        <button id="button-login" type="submit" class="btn btn-default btn-block">
            <i class="icon-login text-xs mr-2"></i> {{__('Login')}}
        </button>
    </div>
</div>
