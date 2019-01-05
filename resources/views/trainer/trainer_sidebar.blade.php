
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

          @if(Auth::user()->master_trainer==1)

          @if(Request::segment(2) == "home")
           <li class="active">   
          <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('home')}}" style="color: #fff !important;">Dashboard</a></li>
          @else
          <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('home')}}">Dashboard</a></li>
          @endif

          @if(Request::segment(2) == "allCustomers" || Request::segment(2) == "mot_show" || Request::segment(2) == "motinsertshow" || Request::segment(2) == "moteditshow" || Request::segment(2) == "purchased-history" || Request::segment(2) == "deactive-order" || Request::segment(2) == "active-order")
            <li class="menu-item-has-children dropdown show" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff !important;"> <i class="menu-icon fa fa-dashboard"></i>Customers</a>
            <ul class="sub-menu children dropdown-menu show"> 
          @else
            <li class="menu-item-has-children dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Customers</a>
            <ul class="sub-menu children dropdown-menu">
          @endif 
          @if(Request::segment(2) == "allCustomers")
          <li><i class="fa fa-id-card-o"></i><a href="{{route('allCustomers')}}" style="color: #fff !important;">All Customers</a></li>
          @else
          <li><i class="fa fa-id-card-o"></i><a href="{{route('allCustomers')}}">All Customers</a></li>
          @endif

          @if(Request::segment(2) == "mot_show" || Request::segment(2) == "motinsertshow" || Request::segment(2) == "moteditshow")
          <li><i class="fa fa-id-card-o"></i><a href="{{route('mot_show')}}" style="color: #fff !important;">MOT</a></li>
          @else 
          <li><i class="fa fa-id-card-o"></i><a href="{{route('mot_show')}}">MOT</a></li>
          @endif

          @if(Request::segment(2) == "purchased-history" || Request::segment(2) == "deactive-order" || Request::segment(2) == "active-order")
          <li><i class="fa fa-id-card-o"></i><a href="{{route('order_history')}}" style="color: #fff !important;">Purchased History</a></li>
          @else 
          <li><i class="fa fa-id-card-o"></i><a href="{{route('order_history')}}">Purchased History</a></li>
          @endif         
          </ul></li>  

          @if(Request::segment(2) == "all-products" || Request::segment(2) == "add-product" || Request::segment(2) == "insert-product" || Request::segment(2) == "edit-product" || Request::segment(2) == "add_coupon" || Request::segment(2) == "our_coupon_list" || Request::segment(2) == "our_coupon_edit_view" || Request::segment(2) == "our_coupon_list"  || Request::segment(2) == "add-package-coupon")
            <li class="menu-item-has-children dropdown show" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff !important;"> <i class="menu-icon fa fa-dashboard"></i>Products</a>
            <ul class="sub-menu children dropdown-menu show"> 
          @else
            <li class="menu-item-has-children dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Products</a>
            <ul class="sub-menu children dropdown-menu">
          @endif 
          @if(Request::segment(2) == "all-products" || Request::segment(2) == "add-product" || Request::segment(2) == "insert-product" || Request::segment(2) == "edit-product")
          <li><i class="fa fa-id-card-o"></i><a href="{{route('view_product')}}" style="color: #fff !important;">Packages</a></li>
          @else
          <li><i class="fa fa-id-card-o"></i><a href="{{route('view_product')}}">Packages</a></li>
          @endif

          @if(Request::segment(2) == "our_coupon_edit_view" || Request::segment(2) == "our_coupon_list" || Request::segment(2) == "add-package-coupon")
          <li><i class="fa fa-id-card-o"></i><a href="{{route('our_coupon_list')}}" style="color: #fff !important;">Discount</a></li>
          @else 
          <li><i class="fa fa-id-card-o"></i><a href="{{route('our_coupon_list')}}">Discount</a></li>
          @endif        
          </ul></li>    
          @if(Request::segment(2) == "add-bootcamp-plan" || Request::segment(2) == "bootcamp-plan" || Request::segment(2) =='edit-bootcamp-plan' || Request::segment(2) =='bootcamp-plan-schedule'  || Request::segment(2) =='show-customer-session-schedule'  || Request::segment(2) =='bootcamp-schedule-booking-cancelled' || Request::segment(2) =='bootcamp_plan_delete' || Request::segment(2) =='edit-bootcamp-plan-schedule'  || Request::segment(2) == "add-bootcamp-session-from-schedule" )
          <li class="menu-item-has-children dropdown show">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Bootcamp</a>
            <ul class="sub-menu children dropdown-menu show"> 
          @else
          <li class="menu-item-has-children dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Bootcamp</a>
            <ul class="sub-menu children dropdown-menu">
            @endif 

            @if(Request::segment(2) == "bootcamp-plan" || Request::segment(2) =='edit-bootcamp-plan' || Request::segment(2) =='add-bootcamp-plan' || Request::segment(2) =='bootcamp_plan_delete')
            <li><i class="fa fa-id-card-o"></i><a href="{{route('bootcamp_plan_list')}}" style="color: #fff !important;">Plans</a></li>
            @else
            <li><i class="fa fa-id-card-o"></i><a href="{{route('bootcamp_plan_list')}}">Plans</a></li>
            @endif

            @if(Request::segment(2) =='bootcamp-plan-schedule'  || Request::segment(2) =='show-customer-session-schedule'  || Request::segment(2) =='bootcamp-schedule-booking-cancelled' || Request::segment(2) =='edit-bootcamp-plan-schedule'  || Request::segment(2) == "add-bootcamp-session-from-schedule" )
            <li><i class="fa fa-id-card-o"></i><a href="{{route('bootcamp_plan_schedule')}}" style="color: #fff !important;">Calender</a></li>
            @else
            <li><i class="fa fa-id-card-o"></i><a href="{{route('bootcamp_plan_schedule')}}">Calender</a></li>
            @endif
          </ul></li>

          @if(Request::segment(2) == "personal-training-plan" || Request::segment(2) == "add-personal-training-plan" || Request::segment(2) =='personal-training-plan-schedule' || Request::segment(2) =='personal-training-plan-schedule-edit' || Request::segment(2) =='add-pt-session-from-schedule')
          <li class="menu-item-has-children dropdown show">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Personal Training</a>
            <ul class="sub-menu children dropdown-menu show"> 
              @else
              <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Personal Training</a>
                <ul class="sub-menu children dropdown-menu">
                  @endif 

                  @if(Request::segment(2) == "personal-training-plan" || Request::segment(2) == "add-personal-training-plan")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('personal_training_plan_list')}}" style="color: #fff !important;">Plans</a></li>
                  @else
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('personal_training_plan_list')}}">Plans</a></li>
                  @endif

                  @if(Request::segment(2) =='personal-training-plan-schedule' || Request::segment(2) =='personal-training-plan-schedule-edit' || Request::segment(2) =='add-pt-session-from-schedule')
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('pt_plan_schedule')}}" style="color: #fff !important;">Calender</a></li>
                  @else
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('pt_plan_schedule')}}">Calender</a></li>
                  @endif

                  </ul></li>
          @if(Request::segment(2) == "common-diet-plan" || Request::segment(2) == "diet-plan-purchases-history" || Request::segment(2) == "add-common-diet-plan" || Request::segment(2) == "edit-common-diet-plan" )

            <li class="menu-item-has-children dropdown show" >
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: #fff !important;"> <i class="menu-icon fa fa-dashboard"></i>Diet</a>
            <ul class="sub-menu children dropdown-menu show"> 
              @else
              <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Diet</a>
                <ul class="sub-menu children dropdown-menu">
                  @endif 
                  @if(Request::segment(2) == "add-common-diet-plan" || Request::segment(2) == "common-diet-plan" || Request::segment(2) == "edit-common-diet-plan")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('common_diet_plan')}}" style="color: #fff !important;">View Common Diet Plan </a></li>
                  @else
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('common_diet_plan')}}">All Plans</a></li>
                  @endif

                  @if(Request::segment(2) == "diet-plan-purchases-history")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('diet_plan_purchases')}}" style="color: #fff !important;">Purchased History</a></li>
                  @else 
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('diet_plan_purchases')}}">Purchased History</a></li>
                  @endif
                </ul></li>

                @if(Request::segment(2) == "trainerlist" || Request::segment(2) == "addtrainer" || Request::segment(2) == "edittrainer" || Request::segment(2) == "gymType" || Request::segment(2) == "add_exercise_trainer" || Request::segment(2) == "editexercise" || Request::segment(2) == "contactlist" || Request::segment(2) == "testimonial_view" || Request::segment(2) == "testimonialshow" || Request::segment(2) == "testimonialedit")
          <li class="menu-item-has-children dropdown show">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Admin</a>
            <ul class="sub-menu children dropdown-menu show"> 
              @else
              <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Admin</a>
                <ul class="sub-menu children dropdown-menu">
                  @endif 

                  @if(Request::segment(2) == "trainerlist" || Request::segment(2) == "addtrainer" || Request::segment(2) == "edittrainer")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('trainerlist')}}" style="color: #fff !important;">Trainers</a></li>
                  @else 
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('trainerlist')}}">Trainers</a></li>
                  @endif

                  @if(Request::segment(2) == "gymType" || Request::segment(2) == "add_exercise_trainer" || Request::segment(2) == "editexercise")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('exercise_list')}}" style="color: #fff !important;">Exercise</a></li>
                  @else 
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('exercise_list')}}">Exercise</a></li>
                  @endif

                  @if(Request::segment(2) == "contactlist")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('contactlist')}}" style="color: #fff !important;">Customer's Enquiry</a></li>
                  @else 
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('contactlist')}}">Customer's Enquiry</a></li>
                  @endif

                  @if(Request::segment(2) == "testimonial_view" || Request::segment(2) == "testimonialshow" || Request::segment(2) == "testimonialedit")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('testimonial_view')}}" style="color: #fff !important;">Testimonial</a></li>
                  @else 
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('testimonial_view')}}">Testimonial</a></li>
                  @endif

            </ul></li>
                  </ul></li>

                  <!-- @if(Request::segment(2) == "feedbacklist")
                    <ul class="nav navbar-nav">
                      <li class="active">
                      <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('feedbacklist')}}" style="color: #fff !important;">Web User Feedback</a></li>
                  @else
                    <ul class="nav navbar-nav">
                      <li class="active">
                      <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('feedbacklist')}}">Web User Feedback</a></li>
                  @endif -->

                      </ul></li></ul></li></ul></li></ul>
                   @else

          @if(Request::segment(2) == "home")
           <li class="active">   
          <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('home')}}" style="color: #fff !important;">Dashboard</a></li>
          @else
          <li><i class="menu-icon fa fa-dashboard"></i><a href="{{route('home')}}">Dashboard</a></li>
          @endif

          @if(Request::segment(2) == "personal-training-plan" || Request::segment(2) == "add-personal-training-plan" || Request::segment(2) =='personal-training-plan-schedule' || Request::segment(2) =='add-pt-session-from-schedule')
          <li class="menu-item-has-children dropdown show">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Personal Training</a>
            <ul class="sub-menu children dropdown-menu show"> 
              @else
              <li class="menu-item-has-children dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="false" aria-expanded="false"> <i class="menu-icon fa fa-dashboard"></i>Personal Training</a>
                <ul class="sub-menu children dropdown-menu">
                  @endif 

                  @if(Request::segment(2) == "personal-training-plan" || Request::segment(2) == "add-personal-training-plan")
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('personal_training_plan_list')}}" style="color: #fff !important;">Plans</a></li>
                  @else
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('personal_training_plan_list')}}">Plans</a></li>
                  @endif

                  @if(Request::segment(2) =='personal-training-plan-schedule' || Request::segment(2) =='add-pt-session-from-schedule')
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('pt_plan_schedule')}}" style="color: #fff !important;">Calender</a></li>
                  @else
                  <li><i class="fa fa-id-card-o"></i><a href="{{route('pt_plan_schedule')}}">Calender</a></li>
                  @endif

                  </ul></li>
                      </ul></li></ul></li></ul></li></ul>
                            
                            @endif
                          </div><!-- /.navbar-collapse -->
                        </nav>
                      </aside>



































