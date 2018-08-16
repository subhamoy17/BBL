@extends('trainerlayouts.trainer_login_template')

@section('content')
<script type="text/javascript">
    /* validation of email,password and confirmation password for forgote password */
$(document).ready(function() {
$('#pwreset').validate({  
  rules: {
    "email": {
      required: true,
      email: true
    },
    "password": {
      required: true,
      minlength: 6
    },
    "password_confirmation": {
        required: true,
        minlength: 6,
        equalTo:"#password"
    }
  },
  messages: {
    "email":{
    email: 'Enter a valid email',
    required:'Please Enter your email'
    },
    "password":{
    minlength: 'Password must be at least 6 characters long',
    required:'Please Enter your password'
    },
    "password_confirmation":{
        minlength: 'Confirm Password must be at least 6 characters long',
        required:'Please Enter Confirm password',
        equalTo:"Please enter confirm password same as password"
    }
  }
});
});
</script>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <br>
             <div class="whole-wrp"></div>
    <div class="logo-m" align="center"><a href="{{route('bbldb')}}"><img src="{{asset('frontend/images/logo.png')}}"></a></div>
    <br>
            <div class="card">
                <div class="card-header">{{ __('Trainer Reset Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('password.reset.success')}}" id="pwreset">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password">

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
