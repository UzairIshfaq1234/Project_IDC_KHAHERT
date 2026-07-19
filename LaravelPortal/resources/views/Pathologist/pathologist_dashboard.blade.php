@extends('app')

@section('pagetitle', 'PATHOLOGIST DASHBOARD')

{{-- ###################----SECTION START----######## --}}
@section('content')


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            @include('Pathologist.pathologist_layout.pathologist_navbar')


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
                                <h4 class="page-title">PATHOLOGIST DASHBOARD</h4>
                                <p class="text-muted page-title-alt">Logined By: {{session()->get('Path_Auth_Session')}}</p>                            
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    
                                    <div class="row">
                                     


                                        
                                         <div class="col-md-12">
                                            
                                            <p class="font-600">Cases Added Today <span class="text-primary pull-right">{{$total_patient_added_today_treated}}</span></p>
                                            <div class="progress m-b-30">
                                              <div class="progress-bar progress-bar-primary progress-animated wow animated" role="progressbar" aria-valuenow="{{$total_patient_added_today_treated}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$total_patient_added_today_treated}}%">
                                              </div><!-- /.progress-bar .progress-bar-danger -->
                                            </div><!-- /.progress .no-rounded -->
                                            
                                            <p class="font-600">Patient Treated By You <span class="text-pink pull-right">{{$patientsTreatedByDoctorCount}}</span></p>
                                            <div class="progress m-b-30">
                                              <div class="progress-bar progress-bar-pink progress-animated wow animated" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: {{$patientsTreatedByDoctorCount}}%">
                                              </div><!-- /.progress-bar .progress-bar-pink -->
                                            </div><!-- /.progress .no-rounded -->
                                            
                                            <p class="font-600">Total Treated Case <span class="text-info pull-right">{{$all_Treated_count}}</span></p>
                                            <div class="progress m-b-30">
                                              <div class="progress-bar progress-bar-info progress-animated wow animated" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width: {{$all_Treated_count}}%">
                                              </div><!-- /.progress-bar .progress-bar-info -->
                                            </div><!-- /.progress .no-rounded -->
                                            
                                            <p class="font-600">Total Not Treated Cases <span class="text-warning pull-right">{{$all_NotTreated_count}}</span></p>
                                            <div class="progress m-b-30">
                                              <div class="progress-bar progress-bar-warning progress-animated wow animated" role="progressbar" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100" style="width: {{$all_NotTreated_count}}%">
                                              </div><!-- /.progress-bar .progress-bar-warning -->
                                            </div><!-- /.progress .no-rounded -->
                                            
                                     
                                            
                                            
                                        </div>
                                        
                                        
                                        
                                    </div>
                                    
                                    <!-- end row -->
                                    
                                </div>
                                
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
                                        <p class="text-muted">CASES ADDED TODAY</p>
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
                                        <h3 class="text-dark"><b class="counter">{{$patientsTreatedByDoctorCount}}</b></h3>
                                        <p class="text-muted">PATIENT YOU TREATED</p>
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
                                        <h3 class="text-dark"><b class="">{{$all_Treated_count}}</b></h3>
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
                                        <h3 class="text-dark"><b class="">{{$all_NotTreated_count}}</b></h3>
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
