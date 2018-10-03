@extends('trainerlayouts.trainer_template')

@section('content')

        <div class="breadcrumbs">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Dashboard</h1>
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
                            <span class="count">{{$future_pending_request}}</span>
                        </h4>
                     <p class="text-light"><a href="{{url('futurePendingRequestlist')}}/{{Auth::user()->id}}" class="small-box-footer">Pending Request <i class="fa fa-arrow-circle-right"></i></a></p>


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
                            <span class="count">{{$future_approve_request}}</span>
                        </h4>
                        <p class="text-light"><a href="{{url('futureRequestlist')}}/{{Auth::user()->id}}" class="small-box-footer">Future Slot Booking Request <i class="fa fa-arrow-circle-right"></i></a></p>

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
                            <span class="count">{{$past_request}}</span>
                        </h4>
                        <p class="text-light"><a href="{{url('pastRequestlist')}}/{{Auth::user()->id}}" class="small-box-footer">Past Slot Booking Request <i class="fa fa-arrow-circle-right"></i></a></p>

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
                            <span class="count">{{$decline_request}}</span>
                        </h4>
                        <p class="text-light"> Total Decline Request</p>

                        <div class="chart-wrapper px-3" style="height:70px;" height="70"/>
                            <!-- <canvas id="widgetChart4"></canvas> -->
                        </div>

                    </div>
                </div>
            </div>
            <!--/.col-->

            <!-- <div class="col-lg-3 col-md-6">
                <div class="social-box facebook">
                    <i class="fa fa-facebook"></i>
                    <ul>
                        <li>
                            <sctrong><span class="count">40</span> k</strong>
                            <span>friends</span>
                        </li>
                        <li>
                            <sctrong><span class="count">450</span></strong>
                            <span>feeds</span>
                        </li>
                    </ul>
                </div> -->
                <!--/social-box-->
           <!--  </div> --><!--/.col-->

<!-- 
            <div class="col-lg-3 col-md-6">
                <div class="social-box twitter">
                    <i class="fa fa-twitter"></i>
                    <ul>
                        <li>
                            <sctrong><span class="count">30</span> k</strong>
                            <span>friends</span>
                        </li>
                        <li>
                            <sctrong><span class="count">450</span></strong>
                            <span>tweets</span>
                        </li>
                    </ul>
                </div> -->
                <!--/social-box-->
         <!--    </div> --><!--/.col-->


           <!--  <div class="col-lg-3 col-md-6">
                <div class="social-box linkedin">
                    <i class="fa fa-linkedin"></i>
                    <ul>
                        <li>
                            <sctrong><span class="count">40</span> +</strong>
                            <span>contacts</span>
                        </li>
                        <li>
                            <sctrong><span class="count">250</span></strong>
                            <span>feeds</span>
                        </li>
                    </ul>
                </div> -->
                <!--/social-box-->
         <!--    </div> --><!--/.col-->

<!-- 
            <div class="col-lg-3 col-md-6">
                <div class="social-box google-plus">
                    <i class="fa fa-google-plus"></i>
                    <ul>
                        <li>
                            <sctrong><span class="count">94</span> k</strong>
                            <span>followers</span>
                        </li>
                        <li>
                            <sctrong><span class="count">92</span></strong>
                            <span>circles</span>
                        </li>
                    </ul>
                </div> -->
                <!--/social-box-->
            <!-- </div> --><!--/.col-->


        </div> <!-- .content -->

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
                            <span class="count">{{$total_number_of_customer}}</span>
                        </h4>
                     <p class="text-light"><a href="{{route('allCustomers')}}" class="small-box-footer">Total Number of Customer<i class="fa fa-arrow-circle-right"></i></a></p>


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
                            <span class="count">{{$total_booking_count_month}}</span>
                        </h4>
                        <p class="text-light">Total Booking in Current Months </p>

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
                            <span class="count">{{$total_booking_qtr}}</span>
                        </h4>
                        <p class="text-light"> Total Booking in last 3 Months</p>

                        <div class="chart-wrapper px-3" style="height:70px;" height="70"/>
                            <!-- <canvas id="widgetChart4"></canvas> -->
                        </div>

                    </div>
                </div>
            </div>
         


        </div> <!-- .content -->
    </div><!-- /#right-panel -->

    <!-- Right Panel -->

@endsection
