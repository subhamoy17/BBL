
<!-- sidebar content of admin panel are here -->
<head>
</head>
<body>
  <link href="{{url('backend/assets/css/style.css')}}" rel="stylesheet">
  <aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">
      <div class="navbar-header">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
          <i class="fa fa-bars"></i>
        </button>
        <a class="navbar-brand" href="#">Logo</a>
        <a class="navbar-brand hidden" href="./"><img src="{{asset('backend/images/logo2.png')}}" alt="Logo"></a>
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

                       @if(Request::segment(1) == "allCustomers")
                       
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('allCustomers')}}" style="color: #fff !important;">All Customers</a></li>
                  @else
                 
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('allCustomers')}}">All Customers</a></li>
                  @endif

                @if(Request::segment(2) == "gymType")
                       <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('gymType')}}" style="color: #fff !important;">Exercise List</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('gymType')}}">Exercise List</a></li>
                  @endif




                @if(Request::segment(2) == "testimonial_view")
                       <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('testimonial_view')}}" style="color: #fff !important;">Testimonial</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('testimonial_view')}}">Testimonial</a></li>
                  @endif



                @if(Request::segment(2) == "mot_show")
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
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('payment_history')}}" style="color: #fff !important;">Payment History</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('payment_history')}}">Payment History</a></li>
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

                  @if(Request::segment(2) == "our_trainer_list")
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
                  @if(Request::segment(1) == "pastRequestlist" || Request::segment(1) == "futureRequestlist"||Request::segment(1) == "futurePendingRequestlist")         
                <li class="menu-item-has-children dropdown show">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i> Slot Request</a>
                  <ul class="sub-menu children dropdown-menu show"> 
                    @else
                    <li class="menu-item-has-children dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i> Slot Request</a>
                      <ul class="sub-menu children dropdown-menu"> 
                        @endif
                        @if(Request::segment(1) == "pastRequestlist")
                        <li><i class="fa fa-id-card-o" ></i><a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}" style="color: #fff !important;">Past Request</a></li>
                        @else
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}">Past Request</a></li>
                        @endif
                        @if(Request::segment(1) == "futureRequestlist")
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('futureRequestlist')}}/{{Auth::user()->id}}" style="color: #fff !important;">Future request</a></li>
                        @else
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('futureRequestlist')}}/{{Auth::user()->id}}">Future request</a></li>
                        @endif

                      @if(Request::segment(1) == "futurePendingRequestlist")
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('futurePendingRequestlist')}}/{{Auth::user()->id}}" style="color: #fff !important;">Future Pending request</a></li>
                        @else
                        <li><i class="fa fa-id-card-o"></i><a href="{{url('futurePendingRequestlist')}}/{{Auth::user()->id}}">Future Pending request</a></li>
                        @endif






                      </ul></li></ul></li></ul></li></ul></li></ul>
                   @else




                        @if(Request::segment(2) == "gymType")
                       <ul class="nav navbar-nav">
                 <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('gymType')}}" style="color: #fff !important;">Exercise List</a></li>
                  @else
                  <ul class="nav navbar-nav">
                  <li class="active">
                  <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('gymType')}}">Exercise List</a></li>
                  @endif



                      @if(Request::segment(1) == "pastRequestlist" || Request::segment(1) == "futureRequestlist" || Request::segment(1) == "futurePendingRequestlist")                   
                      <li class="menu-item-has-children dropdown show">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i> Slot Request</a>
                        <ul class="sub-menu children dropdown-menu show"> 
                          @else
                          <li class="menu-item-has-children dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i> Slot Request</a>
                            <ul class="sub-menu children dropdown-menu">
                              @endif
                              @if(Request::segment(1) == "pastRequestlist")
                              
                              <li><i class="fa fa-id-card-o"></i><a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}" style="color: #fff !important;">Past Request</a></li>
                              @else
                              <li><i class="fa fa-id-card-o"></i><a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}">Past Request</a></li>
                              @endif
                              @if(Request::segment(1) == "futureRequestlist")
                              <li><i class="fa fa-id-card-o"></i><a href= "{{url('futureRequestlist')}}/{{Auth::user()->id}}"style="color: #fff !important;">Future request</a></li>
                              @else
                              <li><i class="fa fa-id-card-o"></i><a href= "{{url('futureRequestlist')}}/{{Auth::user()->id}}">Future request</a></li>
                              @endif
                              @if(Request::segment(1) == "futurePendingRequestlist")
                              <li><i class="fa fa-id-card-o"></i><a href= "{{url('futurePendingRequestlist')}}/{{Auth::user()->id}}"style="color: #fff !important;">Future Pending request</a></li>
                              @else
                              <li><i class="fa fa-id-card-o"></i><a href= "{{url('futurePendingRequestlist')}}/{{Auth::user()->id}}">Future Pending request</a></li>
                              @endif
                            </ul></li></ul></li>
                            @endif
                          </div><!-- /.navbar-collapse -->
                        </nav>
                      </aside>



































