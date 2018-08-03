@extends('frontend.submain') 
@section('content')



      <div class="tab_container">
         @if (session('success'))
                    <div class="alert alert-success">
                            {{ session('success') }}
                           </div>
                   @endif
          <h3 class="d_active tab_drawer_heading" rel="tab4">Tab 4</h3>
          <div id="tab4" class="tab_content">
            <div class="form-box">

                <h4 class="ed-p">Change Password</h4>
                <div class="row">
                    <form class="sch" method="POST" action="{{ route('customer.changepassword.update') }}" id="changepassword">
                          @csrf
                           <input id="email" type="hidden" class="form-control" name="email" value="{{Auth::user()->email}}">

                             <input id="name" type="hidden" class="form-control" name="name" value="{{Auth::user()->name}}">

                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">

                              <label>New Password <small>*</small></label>
                              <input id="new-password" type="password" class="form-control{{ $errors->has('new-password') ? ' is-invalid' : '' }}"placeholder="New Password"  name="new-password">
                                 @if ($errors->has('new-password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('new-password') }}</strong>
                                    </span>
                            @endif

                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Confirm New Password <small>*</small></label>
                                <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" placeholder="Confirm New Password">
                            </div>
                        </div>
                       
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          
                          <button class="lg-in5" type="submit" name="submit" id="submit">
                                      Change Password</button>
                        </div>
                </div>
            </form>
                </div>
              </div>
          </div>
      </div>
</div>
      <!-- .tab_container -->
    </div>
  </div>
@endsection