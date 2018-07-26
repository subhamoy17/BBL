<!-- for extends all i.e. header,footer,sidebar -->
@extends('trainerlayouts.trainer_template')

@section('content')

<!-- validation of new password and new password confirmation for change password -->
<script type="text/javascript">
$(document).ready(function() {    
$('#changepassword').validate({ 
/// rules of error 
  rules: {
    "new-password": {
      required: true,   
      minlength: 6      
    },
    "new-password_confirmation": {
        required: true, 
        minlength: 6,   
        equalTo:"#new-password" 
    }

  },

  ////for show error message
  messages: {
    "new-password":{
    minlength: 'New Password must be at least 6 characters long',
    required:'Please Enter New Password'
    },
    "new-password_confirmation": {
        minlength: 'Confirm New Password must be at least 6 characters long',
        required:'Please Enter Confirm New Password',
        equalTo:'Must be enter confirm password same as new password'
    }
  }
});

});
</script>
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Change Password</h1>
                    </div>
                </div>
            </div>
</div>

<div class="sufee-login d-flex align-content-center flex-wrap">
        <div class="container">
            <div class="login-content">
                <!-- <div class="login-logo">
                    <label>Change Password</label>
                </div> -->
                <div class="login-form">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form class="form-horizontal" method="POST" action="{{ route('trainer.changepassword.update') }}" id="changepassword">
                        @csrf

                        <input id="email" type="hidden" class="form-control" name="email" value="{{Auth::user()->email}}">

                        <input id="name" type="hidden" class="form-control" name="name" value="{{Auth::user()->name}}">

                        <div class="form-group">
                            <label for="new-password">New Password</label>
                            <input id="new-password" type="password" class="form-control{{ $errors->has('new-password') ? ' is-invalid' : '' }}" name="new-password" placeholder="New Password">
                            @if ($errors->has('new-password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                            @endif

                        </div>
                        <div class="form-group">
                            <label for="new-password-confirm">Confirm New Password</label>

                            <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" placeholder="Confirm New Password">

                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-flat m-b-30 m-t-30">Change Password</button>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>

    @endsection