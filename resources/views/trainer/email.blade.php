@extends('trainerlayouts.trainer_login_template')

@section('content')

<script type="text/javascript">
    /* validation of email for reset password */
$(document).ready(function() {
$('#passwordresetform').validate({  
  rules: {
    "email": {
      required: true,
      email: true
    }
  },
  messages: {
    "email":{
    email: 'Enter a valid email',
    required:'Please Enter your email'
    }
  }
});
});
</script>
<div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <!-- <div class="login-logo">
                    <a href="index.html">
                        <img class="align-content" src="{{asset('images/logo.png')}}" alt="">
                    </a>
                </div> -->
                <div class="login-form">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('password.email.trainer') }}" id='passwordresetform'>
                        @csrf
                        <div class="form-group">
                            <label>{{ __('E-Mail Address') }}</label>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required placeholder="Email">

                            @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                        </div>
                        <button type="submit" class="btn btn-primary btn-flat m-b-15">{{ __('Send Password Reset Link') }}</button>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



