<!-- for extends all i.e. header,footer,sidebar -->

@extends('trainerlayouts.trainer_template')

@section('content')

<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


  <div class="breadcrumbs">
    <div class="col-sm-12">
      <div class="page-header float-left">
        <div class="page-title">
          <h1>Personal Training Plan Schedule's Trainer Change</h1>
        </div>
      </div>
    </div>    
  </div>
  <div class="breadcrumbs">
    <div class="col-sm-12">
      <div class="page-header float-left">
        <div class="page-title">
          <h1>{{$all_schedules->address_line1}}; {{$all_schedules->plan_date}}; {{$all_schedules->plan_day}}; {{$all_schedules->start_time}} To {{$all_schedules->end_time}}; {{$all_schedules->trainer_name}};</h1>
        </div>
      </div>
    </div>    
  </div>
<div class="col-lg-12">
	<div class="card">
		<div class="card-body card-block">
			<div class="add_bootcamp_div col-lg-12">
				<form  action="{{route('update_pt_plan_schedules')}}" class="slct-margin" id="submit_bootcamp_session" method="post" autocomplete="off">
					{{ csrf_field() }} 
				 <input type="hidden" name="schedule_id" value="{{$all_schedules->schedule_id}}">
				<div class="row form-group">
          <div class="col-lg-3">
            Change Trainer <span class="required_field_color">*</span>
          </div>
          <div class="col-lg-3">
            @if(count($available_trainer)>0)
              <select id="trainer_id" class="form-control" name="trainer_id">
                @foreach($available_trainer as $all_trainer)
                <option value="{{$all_trainer->id}}" @if($all_trainer->id==$all_schedules->trainer_id) selected @endif >{{$all_trainer->name}}</option>
                @endforeach
              </select>
            @endif
          </div>  
          <div class="col-lg-2">
                <button name="bootcamp_session_submit" id="bootcamp_session_submit" class="btn btn-primary pull-right" style="width: 100px;">Change</button>
              </div>                      
          </div>
			</form>
			</div>
		</div>
	</div>
</div>
 
@endsection

