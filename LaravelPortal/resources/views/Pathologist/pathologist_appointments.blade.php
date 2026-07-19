@extends('app')

@section('pagetitle', 'PATHOLOGIST APPOINTMENT')

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
                                <h4 class="page-title">Patient Appointments</h4>
                                <br>

                            </div>
                        </div>



                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card-box">


                                    <div class="table-rep-plugin">
                                        <div class="table-responsive" data-pattern="priority-columns">
                                            <table id="tech-companies-1" class="table  table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Sampleno</th>
                                                        <th data-priority="1">Name</th>
                                                        <th data-priority="2">Contactno</th>
                                                        <th data-priority="3">Action</th>

                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @foreach ($patient_appointment as $patient_appointmentdata)
                                                        <tr>
                                                            <td>{{ $patient_appointmentdata->Sampleno }}</td>
                                                            <td>{{ $patient_appointmentdata->Name }}</td>
                                                            <td>{{ $patient_appointmentdata->Contactno }}</td>
                                                            <td class="actions ">

                                                                <!-- Custom Modals -->

                                                                <div id="con-close-modal" class="modal fade" tabindex="-1"
                                                                    role="dialog" aria-labelledby="myModalLabel"
                                                                    aria-hidden="true" style="display: none;">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close"
                                                                                    data-dismiss="modal"
                                                                                    aria-hidden="true">×</button>
                                                                                <h4 class="modal-title">Update Appointment
                                                                                </h4>
                                                                            </div>
                                                                            <form
                                                                                action="{{ route('Path.updateAppointment') }}"
                                                                                method="POST" enctype="multipart/form-data"
                                                                                id="form" data-parsley-validate
                                                                                novalidate>
                                                                                {{ csrf_field() }}

                                                                                <div class="modal-body">

                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label for="Name">Sample
                                                                                                    No
                                                                                                    <span
                                                                                                        style="color:red;">*</span></label>
                                                                                                <input disabled
                                                                                                    type="text"
                                                                                                    name="Sampleno"
                                                                                                    parsley-trigger="change"
                                                                                                    required placeholder=""
                                                                                                    class="form-control"
                                                                                                    id="Sampleno">
                                                                                                @error('Sampleno')
                                                                                                    <div class="text-danger">
                                                                                                        {{ $message }}
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label for="Result">Result
                                                                                                    <span
                                                                                                        style="color:red;">*</span></label>

                                                                                                <select name="Result"
                                                                                                    required
                                                                                                    class="form-control">
                                                                                                    <option selected
                                                                                                        disabled>
                                                                                                        Select Result
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="Positive">
                                                                                                        Positive
                                                                                                    </option>
                                                                                                    <option
                                                                                                        value="Negative">
                                                                                                        Negative
                                                                                                    </option>

                                                                                                </select>

                                                                                                @error('Result')
                                                                                                    <div class="text-danger">
                                                                                                        {{ $message }}
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>





                                                                                    <div class="row">
                                                                                        <div class="col-md-12">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="pass1">Pathology
                                                                                                    Image
                                                                                                    <span
                                                                                                        style="color:red;">*</span></label>
                                                                                                <input id="Image"
                                                                                                    type="file"
                                                                                                    name="Image"
                                                                                                    placeholder="Enter Pathology Image"
                                                                                                    required
                                                                                                    class="form-control">

                                                                                                @error('Image')
                                                                                                    <div class="text-danger">
                                                                                                        {{ $message }}
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>






                                                                                    <div class="row">

                                                                                        <div class="form-group col-md-12">

                                                                                            <input type="hidden"
                                                                                                name="Id"
                                                                                                class="form-control"
                                                                                                id="field-4">
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-default waves-effect"
                                                                                        data-dismiss="modal">Close</button>
                                                                                    <button type="submit"
                                                                                        class="btn btn-info waves-effect waves-light">Save
                                                                                        changes</button>
                                                                                </div>
                                                                            </form>

                                                                        </div>
                                                                    </div>
                                                                </div><!-- /.modal -->

                                                                <a href="#"
                                                                    class="on-default waves-effect waves-light edit-button"
                                                                    data-record="{{ json_encode($patient_appointmentdata) }}"
                                                                    data-toggle="modal" data-target="#con-close-modal">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>

                                                                <a href="http://127.0.0.1:5000/" target="_blank">
                                                                    <button style="margin-left: 20px;" class="btn btn-danger waves-effect waves-light">
                                                                        <i class="fa fa-rocket m-r-5"></i>
                                                                        <span>Artificial Intelligence IDC</span>
                                                                    </button>
                                                                </a>
                                                                

                                                            </td>

                                                        </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>

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
                $('.edit-button').click(function() {
                    var recordData = $(this).data('record');
                    $('#Sampleno').val(recordData.Sampleno);

                    $('#field-4').val(recordData.Id);

                    // You can add more fields similarly if needed
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#form').submit(function(e) {
                    e.preventDefault();
                    var routter = @json(route('Path.updateAppointment'));

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
