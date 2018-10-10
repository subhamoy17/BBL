
<!-- header content of admin panel are here -->



<header id="header" class="header">

            <div class="header-menu">

                <div class="col-sm-7">
                    <a id="menuToggle" class="menutoggle pull-left"><i class="fa fa fa-tasks"></i></a>
                   Welcome {{Auth::user()->name}}
                </div>

                <div class="col-sm-5">
                    <div class="user-area dropdown float-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                           
                            <img class="user-avatar rounded-circle" src="{{asset('backend/images')}}/{{Auth::user()->image}}" alt="User Avatar">
                        </a>

                        <div class="user-menu dropdown-menu">
                                <a class="nav-link" href="{{url('adminpanel/showprofile')}}"><i class="fa fa- user"></i>My Profile</a>

                                <a class="nav-link" href="{{url('adminpanel/home/editprofile')}}/{{Auth::user()->id}}"><i class="fa fa -cog"></i>Edit Profile</a>


                                <a class="nav-link" href="{{ route('admin.changepassword') }}"><i class="fa fa -cog"></i>Change Password</a>

                                <a class="nav-link" href="{{ route('adminpanel.logout') }}" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    <i class="fa fa-power -off"></i>Logout
                                </a>

                                <form id="logout-form" action="{{ route('adminpanel.logout') }}" method="POST" style="display: none;">
                                        @csrf
                                </form>
                        </div>
                    </div>

                </div>
            </div>

        </header>