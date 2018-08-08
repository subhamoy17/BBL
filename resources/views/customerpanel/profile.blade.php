@extends('frontend.submain') 
@section('content')



      <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab3">Tab 3</h3>
          <div id="tab3" class="tab_content">
            <div class="form-box">
                <h4 class="ed-p">My Profile</h4>
                <div class="row">
                  <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Full Name</label>
                              <h6>{{$data->name}}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Email </label>
                              <h6>{{$data->email}}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Address </label>
                              <h6>{{$data->address}}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Phone No. </label>
                              <h6>{{$data->ph_no}}</h6>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group file-box">
                              <label>Image</label>

                              <h6><img src="{{asset('backend/images')}}/{{Auth::user()->image}}" height="50"></h6>
                            
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input name="form_botcheck" class="form-control" value="" type="hidden">
                         <button type="submit"  class="btn btn-dark btn-theme-colored btn-flat" data-loading-text="Please wait..."> <a href="{{url('customer/editprofile')}}/{{Auth::user()->id}}">Edit</a></button>
                        </div>
                </div>
                </div>
              </div>
          </div>

         
      </div>
      </div>
      <!-- .tab_container -->
    </div>
  </div>
  
 


@endsection