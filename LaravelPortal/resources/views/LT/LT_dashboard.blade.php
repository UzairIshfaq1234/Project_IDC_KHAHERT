@extends('app')

@section('pagetitle', 'LABORTARY TECHNITIAN DASHBOARD')

{{-- ###################----SECTION START----######## --}}
@section('content')


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            @include('LT.LT_layout.LT_navbar')



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">LABORATORY TECHNICIAN DASHBOARD</h4>
                                <p class="text-muted page-title-alt">Logined By: {{session()->get('LT_Auth_Session')}}</p>                             
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-danger pull-left">
                                        <i class="md-account-box text-danger"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter">{{$total_patient_added_today_treated}}</b></h3>
                                        <p class="text-muted">NO OF PATIENT ADDED TODAY</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-success pull-left">
                                        <i class=" md-group text-success"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter">{{$all_Patient_count}}</b></h3>
                                        <p class="text-muted">TOTAL NO OF PATIENT</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-purple pull-left">
                                        <i class=" md-local-hospital text-purple"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter">{{$last_updated_treated_record}}</b></h3>
                                        <p class="text-muted">LAST PATIENT TREATED ID</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

        
                        </div>

            
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class=" md-local-library text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter">{{$all_Treated_count}}</b></h3>
                                        <p class="text-muted">TOTAL TREATED CASES</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box">
                                    <div class="bg-icon bg-icon-pink pull-left">
                                        <i class=" md-remove-red-eye text-pink"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter">{{$all_NotTreated_count}}</b></h3>
                                        <p class="text-muted">TOTAL NOT TREATED CASES</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                       

        
                        </div>

               
                        <!-- end row -->


                    </div> <!-- container -->

                </div> <!-- content -->
                <footer class="footer text-right">
                    2023 © MUHAMMAD UZAIR ISHFAQ & KHADIJA IBRAHIM.
                </footer>

            </div>


            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

    </body>

    {{-- ###################----SECTION END----######## --}}
@endsection
