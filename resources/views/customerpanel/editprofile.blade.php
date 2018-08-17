@extends('frontend.submain') 
@section('content')


 @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
  
      <div class="tab_container">
          <!-- #tab1 -->
          
          <h3 class="d_active tab_drawer_heading" rel="tab3">Tab 3</h3>
          <div id="tab3" class="tab_content">
            <!-- <div class="form-box"> -->

                <h3 class="ed-p">Edit Profile</h3>
                <div class="form-box">
                <div class="row">

                  <form action="{{route('customer.profileupdate')}}" method="post" enctype="multipart/form-data" class="" id="myeditform">

                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="hidden" name="id" id="id" value="{{$data->id}}">

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Full Name <small>*</small></label>
                              <input type="text" id="name" name="name" placeholder="Name" class="form-control" value="{{$data->name}}">
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Phone No. <small>*</small></label>
                              <input type="text" id="ph_no" name="ph_no" placeholder="Phone No." class="form-control"  value="{{$data->ph_no}}">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Email <small>*</small></label>
                              <input type="text" id="email" name="email" placeholder="Email" class="form-control" value="{{$data->email}}">
                            </div>
                        </div>


                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group">
                              <label>Address <small>*</small></label>
                              <input type="text" id="address" name="address" placeholder="Address" class="form-control" value="{{$data->address}}">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="form-group file-box">
                              <label>Image</label>
                                @if ($errors->any())
                                      <div class="alert alert-danger">
                                        <ul>
                                          @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                          @endforeach
                                        </ul>
                                      </div>
                              @endif
                              <input type="file" id="image" name="image" class="form-control-file">

                                <input type="hidden" id="oldimage" name="oldimage" class="form-control-file" value="{{$data->image}}" height="50" width="50">
                              
                                <img id="profile_thumbnail" src="{{asset('backend/images')}}/{{$data->image}}" alt="profile image"  height="50" width="50"/>
                                     </div>
                              </div>
                              <div class="clearfix"></div>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                          <input name="form_botcheck" class="form-control" value="" type="hidden">
                          <button type="submit" class="btn btn-dark btn-theme-colored btn-flat" data-loading-text="Please wait...">Save</button>
                        </div>
                </div>
                <div class="clearfix"></div>
              </form>
                </div>
              </div>
              <!-- </div> -->
          </div>
      </div>
      </div>
      <!-- .tab_container -->
    </div>
  </div>
  
 


@endsection