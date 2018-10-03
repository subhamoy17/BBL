<!-- for extends all i.e. header,footer,sidebar -->
@extends('trainerlayouts.trainer_login_template')

@section('content')

<!-- validation of  email and password for login -->
<script type="text/javascript">
$(document).ready(function() {
$('#myform').validate({  
    /// rules of error 
  rules: {
    "email": {
      required: true,
      email: true
    },
    "password": {
      required: true,
      minlength: 6
    }
  },
  ////for show error message
  messages: {
    "email":{
    email: 'Enter a valid email',
    required:'Please Enter your email'
    },
    "password": {
      minlength: 'Password must be at least 6 characters long',
      required: 'Please enter your password'
    }
  }
});
});
</script>


<div class="sufee-login d-flex align-content-center flex-wrap">

    <div class="whole-wrp"></div>
    <div class="logo-m" align="center" style="top:1px"><a href="{{route('bbldb')}}"><img src="{{asset('frontend/images/logo.png')}}" style="height: 70px;"></a></div>

        <div class="container">
            <div class="login-content">
                <div class="login-form">

                    @if (session('fisr_change_password_success'))
                        <div class="alert alert-success">
                            {{ session('fisr_change_password_success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" id="myform">
                        @csrf
                        <div class="form-group">
                            <!-- <label>{{ __('E-Mail Address') }}</label> -->
                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="Email" name="email" value="{{ old('email') }}" autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif


                        </div>
                        <div class="form-group">
                            <!-- <label>{{ __('Password') }}</label> -->
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password"  name="password">
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <div class="checkbox">
                            <!-- <label>
                                <input type="checkbox"  {{ old('remember') ? 'checked' : '' }}  name="remember">{{ __('Remember Me') }}
                            </label> -->
                            <label class="pull-right">
                                <a href="{{ route('password.request.trainer') }}">Forgot Password?</a>
                            </label>

                        </div>
                        <button type="submit" class="btn btn-success btn-flat m-b-30 m-t-30">Sign in</button>
                        <!-- <div class="social-login-content">
                            <div class="social-button">
                                <button type="button" class="btn social facebook btn-flat btn-addon mb-3"><i class="ti-facebook"></i>Sign in with facebook</button>
                                <button type="button" class="btn social twitter btn-flat btn-addon mt-2"><i class="ti-twitter"></i>Sign in with twitter</button>
                            </div>
                        </div>
                        <div class="register-link m-t-15 text-center">
                            <p>Don't have account ? <a href="#"> Sign Up Here</a></p>
                        </div> -->
                    </form>
                </div>
            </div>
        </div>
    </div>


    @endsection