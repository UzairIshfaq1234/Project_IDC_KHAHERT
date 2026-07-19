@extends('app')

@section('pagetitle', 'ADMIN DASHBOARD')

{{-- ###################----SECTION START----######## --}}
@section('content')


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            @include('admin.admin_layout.admin_navbar')



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
                                <h4 class="page-title">ADMIN DASHBOARD</h4>
                                <p class="text-muted page-title-alt">Logined By: {{ session()->get('Admin_Auth_Session') }}
                                </p>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 col-lg-4">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-danger pull-left">
                                        <i class="md-account-box text-danger"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b class="counter">{{ $all_admin_count }}</b></h3>
                                        <p class="text-muted">ADMIN</p>
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
                                        <h3 class="text-dark"><b class="counter">{{ $all_LT_count }}</b></h3>
                                        <p class="text-muted">TECHNICIAN</p>
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
                                        <h3 class="text-dark"><b class="counter">{{ $all_Path_count }}</b></h3>
                                        <p class="text-muted">PATHOLOGIST</p>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>


                        </div>
                        <div class="row text-center ">
                            <div class="col-lg-4">
                            </div>
                            <div class="col-lg-4">
                                <div class="card-box">
                                    <div>
                                        <canvas id="myChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                            </div>

                        
                        </div>

                        <div class="row">

                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="text-dark text-center header-title m-t-0 m-b-30">Total Positive Cases</h4>

                                    <div class="widget-chart text-center">
                                        <input class="knob" data-width="150" data-height="150" data-linecap=round
                                            data-fgColor="#fb6d9d" value="{{ $all_Postive_count }}" data-skin="tron"
                                            data-angleOffset="180" data-readOnly=true data-thickness=".15" />

                                        <ul class="list-inline m-t-15">
                                            <li>
                                                <h5 class="text-muted m-t-20">Negative Cases</h5>
                                                <h4 class="m-b-0">{{ $all_Negative_count }}</h4>
                                            </li>
                                            <li>
                                                <h5 class="text-muted m-t-20">Total Cases</h5>
                                                <h4 class="m-b-0">{{ $all_Patient_count }}</h4>
                                            </li>

                                        </ul>
                                    </div>
                                </div>

                            </div>




                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="widget-bg-color-icon card-box fadeInDown animated">
                                    <div class="bg-icon bg-icon-info pull-left">
                                        <i class=" md-local-library text-info"></i>
                                    </div>
                                    <div class="text-right">
                                        <h3 class="text-dark"><b>{{ $all_Treated_count }}</b></h3>
                                        <p class="text-muted">Treated Cases</p>
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
                                        <h3 class="text-dark"><b>{{ $all_NotTreated_count }}</b></h3>
                                        <p class="text-muted">Not Treated Cases</p>
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

    <script>
        const ctx = document.getElementById('myChart');
    
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    'IDC Positive Cases',
                    'IDC Negative Cases',
                ],
                datasets: [{
                    label: 'IDC PIE CHART',
                    data: [{{ $all_Postive_count }}, {{ $all_Negative_count }}],
                    backgroundColor: [
                        'rgb(240, 80, 80)',
                        'rgb(39, 156, 3)',
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                plugins: {
                    title: {
                        display: true,
                        text: 'IDC Pie Chart Analysis',
                        position: 'top',
                        font: {
                            size: 16
                        }
                    }
                },
                scales: {
                    y: {
                        ticks: {
                            beginAtZero: true
                        }
                    }
                }
            }
        });
    </script>
    


    {{-- ###################----SECTION END----######## --}}
@endsection
