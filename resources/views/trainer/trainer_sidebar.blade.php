
<!-- sidebar content of admin panel are here -->
<head>
</head>
<body>
<!-- <div class="loader"></div> -->
  <link href="{{url('backend/assets/css/style.css')}}" rel="stylesheet">
  <aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
      <div class="navbar-header">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('frontend/images/logo.png')}}" hight="100" alt="Logo"></a>
        <a class="navbar-brand hidden" href="{{route('home')}}"><img src="{{asset('frontend/images/logo.png')}}" alt="Logo"></a>
      </div>
      <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">

                  @if(Request::segment(2) == "home")
                   <li class="active">   
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('home')}}" style="color: #fff !important;">Dashboard</a></li>
                  @else
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('home')}}">Dashboard</a></li>
                  @endif

                     @if(Auth::user()->master_trainer==1)

                  @if(Request::segment(2) == "allCustomers")

                  <li class="active"><i class="menu-icon fa fa-dashboard"></i><a href="{{route('allCustomers')}}" style="color: #fff !important;">All Customers</a></li>
                  @else
                 
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('allCustomers')}}">All Customers</a></li>
                  @endif

                @if(Request::segment(2) == "gymType" || Request::segment(2) == "add_exercise_trainer" || Request::segment(2) == "editexercise")
                       <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('gymType')}}" style="color: #fff !important;">Exercise List</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('gymType')}}">Exercise List</a></li>
                  @endif


               <!--    @if(Request::segment(2) == "common-diet-plan")
                  <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('common_diet_plan')}}" style="color: #fff !important;">Common Diet Plan</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('common_diet_plan')}}">Common Diet Plan</a></li>
                  @endif -->

<!-- //////// -->

@if(Request::segment(2) == "common-diet-plan" || Request::segment(2) == "diet-plan-purchases-history" || Request::segment(2) == "add-common-diet-plan" || Request::segment(2) == "edit-common-diet-plan" )

<li class="menu-item-has-children dropdown show" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff !important;"> <i class="menu-icon fa fa-dashboard"></i> Common Diet Plan</a>
            <ul class="sub-menu children dropdown-menu show"> 
              @else
              <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i> Common Diet Plan</a>
                <ul class="sub-menu children dropdown-menu">
                  @endif 
                  @if(Request::segment(2) == "add-common-diet-plan" || Request::segment(2) == "common-diet-plan" || Request::segment(2) == "edit-common-diet-plan")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('common_diet_plan')}}" style="color: #fff !important;">View Common Diet Plan </a></li>
                  @else
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('common_diet_plan')}}">View Common Diet Plan </a></li>
                  @endif

                  @if(Request::segment(2) == "diet-plan-purchases-history")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('diet_plan_purchases')}}" style="color: #fff !important;">Diet Plan Purchases History</a></li>
                  @else 
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('diet_plan_purchases')}}">Diet Plan Purchases History</a></li>
                  @endif
                </ul></li>
<!--  -->


                @if(Request::segment(2) == "add_session")
                 <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('add_session')}}" style="color: #fff !important;">Add Session</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('add_session')}}">Add Session</a></li>
                  @endif

                  @if(Request::segment(2) == "add_coupon" || Request::segment(2) == "our_coupon_list" || Request::segment(2) == "our_coupon_edit_view")
                 <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('our_coupon_list')}}" style="color: #fff !important;">View Coupon</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('our_coupon_list')}}">View Coupon</a></li>
                  @endif

                @if(Request::segment(2) == "testimonial_view" || Request::segment(2) == "testimonialshow" || Request::segment(2) == "testimonialedit")
                       <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('testimonial_view')}}" style="color: #fff !important;">Testimonial</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('testimonial_view')}}">Testimonial</a></li>
                  @endif



                @if(Request::segment(2) == "mot_show" || Request::segment(2) == "motinsertshow" || Request::segment(2) == "moteditshow")
                       <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('mot_show')}}" style="color: #fff !important;">Customer's MOT</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('mot_show')}}">Customer MOT</a></li>
                  @endif

                  @if(Request::segment(2) == "payment_history_backend")
                       <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('payment_history')}}" style="color: #fff !important;">Package Purchased History</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('payment_history')}}">Package Purchased History</a></li>
                  @endif




                  @if(Request::segment(2) == "contactlist")
                       <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('contactlist')}}" style="color: #fff !important;">Customer's Enquiry</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('contactlist')}}">Customer's Enquiry</a></li>
                  @endif

                  @if(Request::segment(2) == "our_trainer_list" || Request::segment(2) == "our_trainer_insert_view" || Request::segment(2) == "our_trainer_edit_view")
                       <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('our_trainer_list')}}" style="color: #fff !important;">Our Trainer</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('our_trainer_list')}}">Our Trainer</a></li>
                  @endif





                  @if(Request::segment(2) == "feedbacklist")
                    <!-- <ul class="nav navbar-nav">
                      <li class="active">
                      <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('feedbacklist')}}" style="color: #fff !important;">Web User Feedback</a></li> -->
                  @else
                    <!-- <ul class="nav navbar-nav">
                      <li class="active">
                      <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('feedbacklist')}}">Web User Feedback</a></li> -->
                  @endif


          @if(Request::segment(2) == "add-slot" || Request::segment(2) == "trainerlist" || Request::segment(2) == "add-slot-record" || Request::segment(2) == "addtrainer" || Request::segment(2) == "editslots" || Request::segment(2) == "edittrainer")
          <li class="menu-item-has-children dropdown show">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i> Trainer Task</a>
            <ul class="sub-menu children dropdown-menu show"> 
              @else
              <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i> Trainer Task</a>
                <ul class="sub-menu children dropdown-menu">
                  @endif 
                  @if(Request::segment(2) == "add-slot" || Request::segment(2) == "add-slot-record" || Request::segment(2) == "editslots")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('addslot')}}" style="color: #fff !important;">Package Pricing</a></li>
                  @else
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('addslot')}}">Package Pricing</a></li>
                  @endif

                  @if(Request::segment(2) == "trainerlist" || Request::segment(2) == "addtrainer" || Request::segment(2) == "edittrainer")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('trainerlist')}}" style="color: #fff !important;">Trainer List</a></li>
                  @else 
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('trainerlist')}}">Trainer List</a></li>
                  @endif
                </ul></li>






                  @if(Request::segment(1) == "pastRequestlist" || Request::segment(1) == "futureRequestlist" || Request::segment(1) == "futurePendingRequestlist" || Request::segment(1) == "canelledlist")         
                <li class="menu-item-has-children dropdown show">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i> Slot Request</a>
                  <ul class="sub-menu children dropdown-menu show"> 
                    @else
                    <li class="menu-item-has-children dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i> Slot Request</a>
                      <ul class="sub-menu children dropdown-menu"> 
                        @endif
                        @if(Request::segment(1) == "pastRequestlist")
                        <li><i class="fa fa-id-card-o" ></i><a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}" style="color: #fff !important;">Past Slot Booking Request</a></li>
                        @else
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}">Past Slot Booking Request</a></li>
                        @endif
                        @if(Request::segment(1) == "futureRequestlist")
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('futureRequestlist')}}/{{Auth::user()->id}}" style="color: #fff !important;">Future Slot Booking Request</a></li>
                        @else
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('futureRequestlist')}}/{{Auth::user()->id}}">Future Slot Booking Request</a></li>
                        @endif

                      @if(Request::segment(1) == "futurePendingRequestlist")
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('futurePendingRequestlist')}}/{{Auth::user()->id}}" style="color: #fff !important;">Pending Request</a></li>
                        @else
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('futurePendingRequestlist')}}/{{Auth::user()->id}}">Pending Request</a></li>
                        @endif

                        @if(Request::segment(1) == "canelledlist")
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('canelledlist')}}" style="color: #fff !important;">Cancelled Request</a></li>
                        @else
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('canelledlist')}}">Cancelled Request</a></li>
                        @endif




                      </ul></li></ul></li></ul></li></ul></li></ul>
                   @else




                        <!-- @if(Request::segment(2) == "gymType")
                       <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('gymType')}}" style="color: #fff !important;">Exercise List</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('gymType')}}">Exercise List</a></li>
                  @endif
 -->
                      @if(Request::segment(2) == "add_session")
                 <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('add_session')}}" style="color: #fff !important;">Add Session</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('add_session')}}">Add Session</a></li>
                  @endif

                      @if(Request::segment(1) == "pastRequestlist" || Request::segment(1) == "futureRequestlist" || Request::segment(1) == "futurePendingRequestlist" || Request::segment(1) == "canelledlist")                   
                      <li class="menu-item-has-children dropdown show">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i> Slot Request</a>
                        <ul class="sub-menu children dropdown-menu show"> 
                          @else
                          <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i> Slot Request</a>
                            <ul class="sub-menu children dropdown-menu">
                              @endif
                              @if(Request::segment(1) == "pastRequestlist")
                              
                              <li><i class="fa fa-id-card-o"></i><a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}" style="color: #fff !important;">Past Slot Booking Request</a></li>
                              @else
                              <li><i class="fa fa-id-card-o"></i><a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}">Past Slot Booking Request</a></li>
                              @endif
                              @if(Request::segment(1) == "futureRequestlist")
                              <li><i class="fa fa-id-card-o"></i><a href= "{{url('futureRequestlist')}}/{{Auth::user()->id}}"style="color: #fff !important;">Future Slot Booking Request</a></li>
                              @else
                              <li><i class="fa fa-id-card-o"></i><a href= "{{url('futureRequestlist')}}/{{Auth::user()->id}}">Future Slot Booking Request</a></li>
                              @endif
                              @if(Request::segment(1) == "futurePendingRequestlist")
                              <li><i class="fa fa-id-card-o"></i><a href= "{{url('futurePendingRequestlist')}}/{{Auth::user()->id}}"style="color: #fff !important;">Pending Request</a></li>
                              @else
                              <li><i class="fa fa-id-card-o"></i><a href= "{{url('futurePendingRequestlist')}}/{{Auth::user()->id}}">Pending Request</a></li>
                              @endif

                               @if(Request::segment(1) == "canelledlist")
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('canelledlist')}}" style="color: #fff !important;">Cancelled Request</a></li>
                        @else
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('canelledlist')}}">Cancelled Request</a></li>
                        @endif
                            </ul></li></ul></li>
                            @endif
                          </div><!-- /.navbar-collapse -->
                        </nav>
                      </aside>



































