@extends('trainerlayouts.trainer_template')

@section('content')

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>@if(Auth::user()->master_trainer==2)
                                Welcome {{Auth::user()->name}} 
                            @else 
                                Dashboard
                            @endif</h1>
                    </div>
                </div>
            </div>
        </div>
<div class="content mt-3">
            @if(Auth::user()->master_trainer==1)
           <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-1">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$total_number_of_customer}}</span>
                        </h4>
                     <p class="text-light"><a href="{{route('allCustomers')}}" class="small-box-footer">Total Number of Customer<i class="fa fa-arrow-circle-right"></i></a></p>


                        <div class="chart-wrapper px-0" style="height:70px;" height="70"/>
                      <!--  -->
                        </div>

                    </div>

                </div>
            </div>
            
            <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-2">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$total_number_of_trainer}}</span>
                        </h4>
                        <p class="text-light"><a href="{{url('trainer/trainerlist')}}" class="small-box-footer">Total Number of Trainer <i class="fa fa-arrow-circle-right"></i></a></p>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70"/>
                          <!--   <canvas id="widgetChart2"></canvas> -->
                        </div>

                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-3">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$total_bootcamop_booking_count_month}}</span>
                        </h4>
                        <p class="text-light">Total Bootcamp Booking in Current Month</p>

                    </div>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70"/>
                     <!--  <a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                        </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-4">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">0</span>
                        </h4>
                        <p class="text-light"> Total PT Booking in Current Month</p>

                        <div class="chart-wrapper px-3" style="height:70px;" height="70"/>
                            <!-- <canvas id="widgetChart4"></canvas> -->
                        </div>

                    </div>
                </div>
            </div>
         


        </div> <!-- .content -->
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Bootcamp</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">


           <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-1">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$total_bootcamop_future_booking}}</span>
                        </h4>
                     <p class="text-light"><a href="{{url('trainer/bootcamp-plan-schedule')}}" class="small-box-footer">Future Request for Bootcamp <i class="fa fa-arrow-circle-right"></i></a></p>


                        <div class="chart-wrapper px-0" style="height:70px;" height="70"/>
                      <!--  -->
                        </div>

                    </div>

                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-2">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$total_bootcamop_past_booking}}</span>
                        </h4>
                        <p class="text-light"><a href="{{url('trainer/bootcamp-plan-schedule')}}" class="small-box-footer">Past Request for Bootcamp <i class="fa fa-arrow-circle-right"></i></a></p>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70"/>
                          <!--   <canvas id="widgetChart2"></canvas> -->
                        </div>

                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-3">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$total_bootcamop_cancelled_booking}}</span>
                        </h4>
                        <p class="text-light"><a href="{{url('trainer/bootcamp-plan-schedule')}}" class="small-box-footer">Cancelled Request for Bootcamp <i class="fa fa-arrow-circle-right"></i></a></p>

                    </div>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70"/>
                     <!--  <a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                        </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-4">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">{{$total_bootcamop_declined_booking}}</span>
                        </h4>
                        <p class="text-light"><a href="{{url('trainer/bootcamp-plan-schedule')}}" class="small-box-footer">Declined Request for Bootcamp <i class="fa fa-arrow-circle-right"></i></a></p>
                        <div class="chart-wrapper px-3" style="height:70px;" height="70"/>
                            <!-- <canvas id="widgetChart4"></canvas> -->
                        </div>

                    </div>
                </div>
            </div>
          


        </div> <!-- .content -->
<div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Personal Training</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="content mt-3">
           <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-1">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">0</span>
                        </h4>
                     <p class="text-light"><a href="{{url('trainer/home')}}" class="small-box-footer">Future Request for PT Session <i class="fa fa-arrow-circle-right"></i></a></p>


                        <div class="chart-wrapper px-0" style="height:70px;" height="70"/>
                      <!--  -->
                        </div>

                    </div>

                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-2">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">0</span>
                        </h4>
                        <p class="text-light"><a href="{{url('trainer/home')}}" class="small-box-footer">Past Request for PT Session <i class="fa fa-arrow-circle-right"></i></a></p>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70"/>
                          <!--   <canvas id="widgetChart2"></canvas> -->
                        </div>

                    </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-3">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">0</span>
                        </h4>
                        <p class="text-light"><a href="{{url('trainer/home')}}" class="small-box-footer">Cancelled Request for PT Session <i class="fa fa-arrow-circle-right"></i></a></p>

                    </div>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70"/>
                     <!--  <a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
                        </div>
                </div>
            </div>
            <!--/.col-->

            <div class="col-sm-6 col-lg-3">
                <div class="text-white bg-flat-color-4">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton" data-toggle="dropdown">
                                <i class=""></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="#">Action</a>
                                    <a class="dropdown-item" href="#">Another action</a>
                                    <a class="dropdown-item" href="#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <h4 class="mb-0">
                            <span class="count">0</span>
                        </h4>
                        <p class="text-light"><a href="{{url('trainer/home')}}" class="small-box-footer">Declined Request for PT Session <i class="fa fa-arrow-circle-right"></i></a></p>
                        <div class="chart-wrapper px-3" style="height:70px;" height="70"/>
                            <!-- <canvas id="widgetChart4"></canvas> -->
                        </div>

                    </div>
                </div>
            </div>
          


        </div> <!-- .content -->


    </div><!-- /#right-panel -->

    <!-- Right Panel -->
    @endif

@endsection
