@extends('app')

@section('pagetitle', 'Add Patient')

@section('content')
    <div class="idc-shell">

        @include('LT.LT_layout.LT_navbar')

        <div class="idc-main">

            @include('layouts.topbar', [
                'title' => 'Add Patient',
                'crumb' => 'Lab Technician · Patients',
                'userName' => session('LT_Auth_Session'),
                'avatarFile' => session('LT_Role_Image'),
            ])

            <div class="idc-content">
                <div class="row justify-content-center">
                    <div class="col-xxl-8 col-xl-9">

                        <div class="idc-card anim-fade-up">
                            <div class="card-head">
                                <div>
                                    <h6><i class="bi bi-person-add me-2 text-gradient"></i>Register New Patient Sample</h6>
                                    <div class="sub">The patient receives an automatic email confirmation on registration</div>
                                </div>
                                <span class="badge-soft badge-soft-success"><span class="dot"></span>Email notification enabled</span>
                            </div>

                            <div class="card-inner">
                                <form action="{{ route('patient.adddata') }}" method="POST" enctype="multipart/form-data"
                                    id="form" novalidate>
                                    {{ csrf_field() }}

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label" for="Sampleno">Sample No <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-upc-scan"></i>
                                                <input type="text" name="Sampleno" required placeholder="Unique sample number"
                                                    class="form-control" id="Sampleno">
                                            </div>
                                            @error('Sampleno')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="Name">Patient Name <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-person"></i>
                                                <input type="text" name="Name" required placeholder="Full name"
                                                    class="form-control" id="Name">
                                            </div>
                                            @error('Name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="emailAddress">Email Address <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-envelope"></i>
                                                <input type="email" name="Email" required placeholder="patient@email.com"
                                                    class="form-control" id="emailAddress">
                                            </div>
                                            @error('Email')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="contactNo">Contact No <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-telephone"></i>
                                                <input id="contactNo" type="text" name="ContactNo" placeholder="03XXXXXXXXX"
                                                    maxlength="11" required class="form-control">
                                            </div>
                                            @error('ContactNo')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-center gap-2 mt-4">
                                        <div class="small text-muted fw-semibold me-auto">
                                            <i class="bi bi-envelope-check me-1"></i>
                                            Registered by <strong>{{ session('LT_Auth_Session') }}</strong>
                                        </div>
                                        <button type="reset" class="btn btn-soft">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                                        </button>
                                        <button class="btn btn-gradient" type="submit">
                                            <i class="bi bi-check2-circle me-1"></i>Register Patient
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <footer class="idc-footer">
                <span>© {{ date('Y') }} IDC Portal — Muhammad Uzair Ishfaq &amp; Khadija Ibrahim</span>
                <span><i class="bi bi-cpu me-1"></i>AI-assisted histopathology</span>
            </footer>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#form').submit(function(e) {
                e.preventDefault();
                var routter = @json(route('patient.adddata'));

                var formData = new FormData(this);
                var submitBtn = $(this).find('button[type="submit"]');
                submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving…');

                $.ajax({
                    url: routter,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.message,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        submitBtn.prop('disabled', false).html('<i class="bi bi-check2-circle me-1"></i>Register Patient');
                        if (xhr.status === 422) {
                            var errors = xhr.responseJSON.errors;
                            var errorMessage = '';
                            $.each(errors, function(key, value) {
                                errorMessage += value[0] + '<br>';
                            });
                            Swal.fire({
                                icon: 'error',
                                title: 'Validation Error',
                                html: errorMessage,
                            });
                        } else {
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
@endpush
