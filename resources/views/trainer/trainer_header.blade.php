
<!-- header content of admin panel are here -->



<header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                   
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           Welcome {{Auth::user()->name}} &nbsp;
                            <img class="user-avatar rounded-circle" src="{{asset('backend/images')}}/{{Auth::user()->image}}" alt="Trainer">
                        </a>


                        <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="{{url('trainer/home')}}/{{Auth::user()->id}}"><i class="fa fa- user"></i>My Profile</a>

                                <a class="nav-link" href="{{url('trainer/editprofile')}}/{{Auth::user()->id}}"><i class="fa fa -cog"></i>Edit Profile</a>


                                <a class="nav-link" href="{{ route('trainer.changepassword') }}"><i class="fa fa -cog"></i>Change Password</a>

                                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power -off"></i>Logout
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                </form>
                        </div>
                    </div>

                </div>
            </div>

        </header>