@extends('app')

@section('pagetitle', 'ADD PATIENT')

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



                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card-box">
                                    <h4 class="m-t-0 header-title"><b>Add Patient</b></h4>
                                    <p class="text-muted font-13 m-b-30">
                                        Add your details correctly.
                                    </p>


                                    <form action="{{ route('patient.adddata') }}" method="POST"
                                        enctype="multipart/form-data" id="form" data-parsley-validate novalidate>
                                        {{ csrf_field() }}


                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="userName">Sample No <span
                                                            style="color:red;">*</span></label>
                                                    <input type="text" name="Sampleno" parsley-trigger="change" required
                                                        placeholder="Enter Sample No" class="form-control" id="Sampleno">
                                                    @error('Sampleno')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="Name">Name <span style="color:red;">*</span></label>
                                                    <input type="text" name="Name" parsley-trigger="change" required
                                                        placeholder="Enter  Name" class="form-control" id="Name">
                                                    @error('Name')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>





                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="emailAddress">Email Address <span
                                                            style="color:red;">*</span></label>
                                                    <input type="email" name="Email" parsley-trigger="change" required
                                                        placeholder="Enter Email" class="form-control" id="emailAddress">
                                                    @error('Email')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="pass1">Contact No <span
                                                            style="color:red;">*</span></label>
                                                    <input id="pass1" type="text" name="ContactNo"
                                                        placeholder="Enter Contact No" maxlength="11" required
                                                        class="form-control">

                                                    @error('ContactNo')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>








                                        <br>

                                        <div class="form-group text-right m-b-0 m-t-20">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">
                                                Submit
                                            </button>
                                            <button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
                                                Cancel
                                            </button>
                                        </div>

                                    </form>
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

        <script>
            $(document).ready(function() {
                $('#form').submit(function(e) {
                    e.preventDefault();
                    var routter = @json(route('patient.adddata'));

                    var formData = new FormData(this); // Create a FormData object from the form

                    $.ajax({
                        url: routter,
                        type: "POST",
                        data: formData, // Use FormData object
                        processData: false, // Don't process the data
                        contentType: false, // Don't set content type (let jQuery handle it)
                        success: function(response) {
                            // Handle success response
                            console.log(response);

                            // Show success notification to the user
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect back after the success notification
                                    window.location.reload();
                                }
                            });
                        },
                        error: function(xhr) {
                            if (xhr.status === 422) {
                                // If validation fails, display errors
                                var errors = xhr.responseJSON.errors;
                                var errorMessage = '';
                                $.each(errors, function(key, value) {
                                    errorMessage += value[0] + '<br>';
                                });
                                // Show error notification to the user
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Validation Error',
                                    html: errorMessage,
                                });
                            } else {
                                // Handle other error cases
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'Something went wrong. Please try again.',
                                });
                            }
                        }
                    });
                });
            });
        </script>

    </body>

    {{-- ###################----SECTION END----######## --}}
@endsection
