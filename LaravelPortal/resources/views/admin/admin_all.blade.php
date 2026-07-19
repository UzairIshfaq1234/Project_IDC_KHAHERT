@extends('app')

@section('pagetitle', 'ALL ADMIN')

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



                        <!-- End row -->
                        <!-- Page-Title -->
                        <div class="row ">
                            <div class="col-sm-12">
                                <h4 class="page-title ">All Admins</h4>

                            </div>


                        </div>
                        <br>


                        <div class="panel">

                            <div class="panel-body">




                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="card-box">


                                            <table id="demo-foo-filtering" class="table table-responsive table-striped toggle-circle m-b-0"
                                                data-page-size="7">
                                                <thead>
                                                    <tr>
                                                        <th data-toggle="true">Username</th>
                                                        <th data-hide="phone,tablet">Passsword</th>
                                                        <th data-hide="phone,tablet">Email</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <div class="form-inline m-b-20">
                                                    <div class="row">
                                                        <div class="col-sm-6 text-xs-center">
                                                            <div class="form-group">

                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 text-xs-center text-right">
                                                            <div class="form-group">
                                                                <input id="demo-foo-search" type="text"
                                                                    placeholder="Search" class="form-control input-sm"
                                                                    autocomplete="on">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <tbody>
                                                    @foreach ($all_admin_records as $record)
                                                        <tr class="gradeX">

                                                            <td>{{ $record->Username }}</td>

                                                            <td>{{ $record->Password }}</td>
                                                            <td>{{ $record->Email }}</td>

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
                                                                                <h4 class="modal-title">Update Login Data
                                                                                </h4>
                                                                            </div>
                                                                            <form action="{{ route('admin.updateadmin') }}"
                                                                                method="POST" enctype="multipart/form-data"
                                                                                id="form" data-parsley-validate
                                                                                novalidate>
                                                                                {{ csrf_field() }}

                                                                                <div class="modal-body">

                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label for="userName">Name
                                                                                                    <span
                                                                                                        style="color:red;">*</span></label>
                                                                                                <input type="text"
                                                                                                    name="Name"
                                                                                                    parsley-trigger="change"
                                                                                                    required
                                                                                                    placeholder="Enter Name"
                                                                                                    class="form-control"
                                                                                                    id="Name">
                                                                                                @error('name')
                                                                                                    <div class="text-danger">
                                                                                                        {{ $message }}
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>

                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="Username">Username
                                                                                                    <span
                                                                                                        style="color:red;">*</span></label>
                                                                                                <input type="text"
                                                                                                    name="Username"
                                                                                                    parsley-trigger="change"
                                                                                                    required
                                                                                                    placeholder="Enter Unique Username"
                                                                                                    class="form-control"
                                                                                                    id="Username">
                                                                                                @error('Username')
                                                                                                    <div class="text-danger">
                                                                                                        {{ $message }}
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>





                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="emailAddress">Email
                                                                                                    Address <span
                                                                                                        style="color:red;">*</span></label>
                                                                                                <input type="email"
                                                                                                    name="Email"
                                                                                                    parsley-trigger="change"
                                                                                                    required
                                                                                                    placeholder="Enter Email"
                                                                                                    class="form-control"
                                                                                                    id="Email">
                                                                                                @error('Email')
                                                                                                    <div class="text-danger">
                                                                                                        {{ $message }}
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">

                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="pass1">Password
                                                                                                    <span
                                                                                                        style="color:red;">*</span></label>

                                                                                                <input id="Password"
                                                                                                    type="text"
                                                                                                    name="Password"
                                                                                                    placeholder="Password"
                                                                                                    required
                                                                                                    class="form-control">

                                                                                                @error('Password')
                                                                                                    <div class="text-danger">
                                                                                                        {{ $message }}
                                                                                                    </div>
                                                                                                @enderror
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>

                                                                                    <div class="row">
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="pass1">Role<span
                                                                                                        style="color:red;">*</span></label>
                                                                                                <div>
                                                                                                    <select id="Role" name="Role"
                                                                                                        required
                                                                                                        class="form-control">
                                                                                                        <option selected
                                                                                                            disabled>Select
                                                                                                            Role</option>
                                                                                                        <option
                                                                                                            value="1">
                                                                                                            Admin</option>
                                                                                                        <option
                                                                                                            value="2">
                                                                                                            Laboratory
                                                                                                            Technician
                                                                                                        </option>
                                                                                                        <option
                                                                                                            value="3">
                                                                                                            Pathologist
                                                                                                        </option>
                                                                                                    </select>

                                                                                                    @error('Role')
                                                                                                        <div
                                                                                                            class="text-danger">
                                                                                                            {{ $message }}
                                                                                                        </div>
                                                                                                    @enderror

                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                            <div class="form-group">
                                                                                                <label
                                                                                                    for="pass1">Contact
                                                                                                    No <span
                                                                                                        style="color:red;">*</span></label>
                                                                                                <input id="Contactno"
                                                                                                    type="text"
                                                                                                    name="ContactNo"
                                                                                                    placeholder="Enter Contact No"
                                                                                                    required
                                                                                                    class="form-control">

                                                                                                @error('ContactNo')
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
                                                                    data-record="{{ json_encode($record) }}"
                                                                    data-toggle="modal" data-target="#con-close-modal">
                                                                    <i class="fa fa-pencil"></i>
                                                                </a>
                                                                <a href="{{ route('admin.deladmin', ['id' => $record->Id]) }}"
                                                                    class="on-default delete-link-admin"
                                                                    data-id="{{ $record->Id }}">
                                                                    <i class="fa fa-trash-o"></i>
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
                            <!-- end: page -->

                        </div>
                    </div>
                </div>

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
                $('.delete-link-admin').click(function(event) {
                    event.preventDefault(); // Prevent the default link behavior

                    var deleteUrl = $(this).attr('href');
                    var recordId = $(this).data('id');

                    // Show confirmation dialog
                    Swal.fire({
                        title: 'Delete Confirmation',
                        text: 'Are you sure you want to delete this record?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#5FBEAA',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Proceed with deletion
                            deleteRecord(deleteUrl, recordId);
                        }
                    });
                });

                function deleteRecord(url, id) {
                    $.ajax({
                        url: url,
                        type: "GET", // or "POST" based on your route definition
                        success: function(response) {
                            // Handle success response
                            console.log(response);

                            // Show success notification to the user
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.toast_message,
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect back after the success notification
                                    window.location.reload();
                                }
                            });
                        },
                        error: function(xhr) {
                            // Handle error cases
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Something went wrong. Please try again.',
                            });
                        }
                    });
                }
            });
        </script>


        <script>
            $(document).ready(function() {
                $('.edit-button').click(function() {
                    var recordData = $(this).data('record');
                    $('#Name').val(recordData.Name);
                    $('#Username').val(recordData.Username);
                    $('#Email').val(recordData.Email);
                    $('#Password').val(recordData.Password);
                    $('#Role').val(recordData.Role);
                    $('#Contactno').val(recordData.Contactno);

                    $('#field-4').val(recordData.Id);

                    // You can add more fields similarly if needed
                });
            });
        </script>
        <script>
            $(document).ready(function() {
                $('#form').submit(function(e) {
                    e.preventDefault();
                    var routter = @json(route('admin.updateadmin'));

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
