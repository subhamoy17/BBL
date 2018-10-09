@extends('frontend.submain') 
@section('content')

 

      <div class="tab_container">
          <h3 class="d_active tab_drawer_heading" rel="tab3">Tab 3</h3>
          <div id="tab3" class="tab_content">
           <h3 class="ed-p">My Profile</h3>
            <div class="form-box">
              @if($data)
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
                              @if($data->address)
                              <h6>{{$data->address}}</h6>
                               @else
                                    <h6>N/A</h6>
                                 @endif
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
                              @if(Auth::user()->image)
                              <h6><img src="{{asset('backend/images')}}/{{Auth::user()->image}}" height="50"></h6>
                              @else
                                    <h6>N/A</h6>
                                 @endif
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input name="form_botcheck" class="form-control" value="" type="hidden">
                         <a href="{{url('customer/editprofile')}}/{{Auth::user()->id}}"><button type="submit"  class="btn btn-dark btn-theme-colored btn-flat" data-loading-text="Please wait..."> Edit</button></a>
                        </div>
                </div>
                </div>
                   @endif
              </div>
          </div>

         
      </div>



   
     

@endsection