            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="#" class="logo"><span style="font-size: 15px;font-weight:bold;">I D
                            C </span>
                            <span style="font-size: 12px;font-weight:bold;color:white;">Cancer Detection</span>
                        </a>
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left">
                                    <i class="ion-navicon"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>

           

                            <ul class="nav navbar-nav navbar-right pull-right">

                                <li class="hidden-xs">
                                    <a href="#" id="btn-fullscreen" class="waves-effect waves-light"><i
                                            class="icon-size-fullscreen"></i></a>
                                </li>

                                <li class="dropdown">
                                    <a href="" class="dropdown-toggle profile" data-toggle="dropdown"
                                        aria-expanded="true"><img
                                            src="{{ asset('Admin_Images/' . session('Admin_Role_Image')) }}" alt="user-img"
                                            class="img-circle"> </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0)"><i class="ti-user m-r-5"></i> Profile</a></li>

                                        <li><a href="{{ route('Page.logout') }}"><i class="ti-power-off m-r-5"></i>
                                                Logout</a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>

                            <li class="text-muted menu-title">ADMIN</li>

                            <li class="">
                                <a href="{{ route('admin.dashboard_page') }}" class="waves-effect"><i
                                        class="ti-home"></i> <span>Admin Dashboard
                                    </span> </a>
                                    
                            </li>
                            <li class="has_sub">
                                <a href="#" class="waves-effect"><i class="md-account-circle"></i>
                                    <span>Logins
                                    </span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="{{ route('admin.add') }}">Add Logins</a></li>
                                    <li><a href="{{ route('admin.alladmin') }}">All Logins</a></li>
                                </ul>
                            </li>



                            <li class="text-muted menu-title">LABORATORY TECHNICIAN</li>

                            <li class="">
                                <a href="{{ route('LT.dashboard_page') }}" class="waves-effect"><i
                                        class="ti-home"></i> <span>LT Dashboard
                                    </span> </a>
                            </li>
                            <li class="has_sub">
                                <a href="#" class="waves-effect"><i class=" md-accessibility"></i>
                                    <span>Patients
                                    </span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="{{ route('patient.add') }}">Add Patients</a></li>
                                    <li><a href="{{ route('patient.allpatient') }}">All Patients</a></li>
                                </ul>
                            </li>

                            <li class="text-muted menu-title">PATHOLOGIST</li>

                            <li class="">
                                <a href="{{ route('Path.dashboard_page') }}" class="waves-effect"><i
                                        class="ti-home"></i> <span>Pathologist Dashboard
                                    </span> </a>
                            </li>
                            <li class="has_sub">
                                <a href="#" class="waves-effect"><i class=" md-local-pharmacy"></i>
                                    <span>Patients Appointment
                                    </span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="{{ route('Path.Appointments') }}">Appointments</a></li>
                                </ul>
                            </li>




                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->
