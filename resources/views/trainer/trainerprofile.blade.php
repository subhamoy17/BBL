
<!-- for extends all i.e. header,footer,sidebar -->
@extends('trainerlayouts.trainer_template')

@section('content')


<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Trainer Profile</h1>
                    </div>
                </div>
            </div>
</div>
<div class="container-fluid">
  <div class="wrp-1">
<div class="row">
        <div class="col-lg-3">
          @if(Auth::user()->image)
          <img src="{{asset('backend/images')}}/{{Auth::user()->image}}">
          @else
          <img src="{{asset('backend/images/no-profile-image.jpg')}}">
          @endif
        </div>
        <div class="col-lg-9">
        <div class="card">
                      <div class="card-body card-block  col-lg-12">
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Name:</label></div>
                            <div class="col-12 col-md-9">{{$data->name}}</div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Email:</label></div>
                            <div class="col-12 col-md-9">{{$data->email}}</div>
                          </div>
                          <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Contact No.:</label></div>
                            <div class="col-12 col-md-9">{{$data->contact_no}}</div>
                          </div>
                           <div class="row form-group">
                            <div class="col col-md-3"><label for="text-input" class=" form-control-label">Address:</label></div>
                            <div class="col-12 col-md-9">{{$data->address}}</div>
                          </div>  
                      </div>
                    </div>
                    </div>
                    </div>
                  </div>
                  </div>

    @endsection