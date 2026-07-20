@extends('app')

@section('pagetitle', 'Add Logins')

@section('content')
    <div class="idc-shell">

        @include('admin.admin_layout.admin_navbar')

        <div class="idc-main">

            @include('layouts.topbar', [
                'title' => 'Add Logins',
                'crumb' => 'Administrator · Team Management',
                'userName' => session('Admin_Auth_Session'),
                'avatarFile' => session('Admin_Role_Image'),
            ])

            <div class="idc-content">
                <div class="row justify-content-center">
                    <div class="col-xxl-9">

                        <div class="idc-card anim-fade-up">
                            <div class="card-head">
                                <div>
                                    <h6><i class="bi bi-person-plus me-2 text-gradient"></i>Create Team Member Login</h6>
                                    <div class="sub">Register a new Admin, Laboratory Technician or Pathologist account</div>
                                </div>
                                <span class="badge-soft badge-soft-primary"><span class="dot"></span>Secure onboarding</span>
                            </div>

                            <div class="card-inner">
                                <form action="{{ route('admin.adddata') }}" method="POST" enctype="multipart/form-data"
                                    id="form" novalidate>
                                    {{ csrf_field() }}

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label" for="userName">Full Name <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-person"></i>
                                                <input type="text" name="Name" required placeholder="e.g. Dr. Sarah Ahmed"
                                                    class="form-control" id="userName">
                                            </div>
                                            @error('Name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="Username">Username <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-at"></i>
                                                <input type="text" name="Username" required placeholder="Unique username"
                                                    class="form-control" id="Username">
                                            </div>
                                            @error('Username')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="emailAddress">Email Address <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-envelope"></i>
                                                <input type="email" name="Email" required placeholder="name@hospital.com"
                                                    class="form-control" id="emailAddress">
                                            </div>
                                            @error('Email')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label" for="pass1">Password <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-shield-lock"></i>
                                                <input id="pass1" type="password" name="Password"
                                                    placeholder="8–15 characters" required class="form-control">
                                                <button type="button" class="toggle-password" tabindex="-1" aria-label="Show password">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                            @error('Password')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Role <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-person-gear"></i>
                                                <select name="Role" required class="form-select">
                                                    <option selected disabled>Select Role</option>
                                                    <option value="1">Admin</option>
                                                    <option value="2">Laboratory Technician</option>
                                                    <option value="3">Pathologist</option>
                                                </select>
                                            </div>
                                            @error('Role')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="form-label">Contact No <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-telephone"></i>
                                                <input type="text" name="ContactNo" placeholder="03XXXXXXXXX"
                                                    maxlength="11" required class="form-control">
                                            </div>
                                            @error('ContactNo')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Profile Photo <span class="req">*</span></label>
                                            <div class="file-drop">
                                                <input type="file" name="Image" accept="image/jpeg,image/png,image/jpg" hidden>
                                                <i class="bi bi-cloud-arrow-up"></i>
                                                <div class="fw-bold mt-2">Drop photo here or click to browse</div>
                                                <div class="fd-hint">JPEG / PNG · up to 3 MB · auto-resized to 128×128</div>
                                                <div class="fd-name"></div>
                                            </div>
                                            @error('Image')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end gap-2 mt-4">
                                        <button type="reset" class="btn btn-soft">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i>Reset
                                        </button>
                                        <button class="btn btn-gradient" type="submit">
                                            <i class="bi bi-check2-circle me-1"></i>Create Login
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
                var routter = @json(route('admin.adddata'));

                var formData = new FormData(this);

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
