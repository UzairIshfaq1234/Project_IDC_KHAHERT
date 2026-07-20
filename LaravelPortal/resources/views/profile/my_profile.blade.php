@extends('app')

@section('pagetitle', 'My Profile')

@php
    $roleLabels = [1 => 'Administrator', 2 => 'Lab Technician', 3 => 'Pathologist'];
    $roleLabel = $roleLabels[$account->Role] ?? 'Team Member';
@endphp

@section('content')
    <div class="idc-shell">

        @if (session()->has('Admin_Auth_Session'))
            @include('admin.admin_layout.admin_navbar')
        @elseif (session()->has('LT_Auth_Session'))
            @include('LT.LT_layout.LT_navbar')
        @else
            @include('Pathologist.pathologist_layout.pathologist_navbar')
        @endif

        <div class="idc-main">

            @include('layouts.topbar', [
                'title' => 'My Profile',
                'crumb' => $roleLabel . ' · Account Settings',
                'userName' => $account->Username,
                'avatarFile' => $account->Image,
            ])

            <div class="idc-content">

                {{-- ===== Profile hero ===== --}}
                <div class="profile-hero anim-fade-up mb-4">
                    <span class="hero-deco" style="width:220px;height:220px;right:-60px;top:-110px;"></span>
                    <span class="hero-deco" style="width:140px;height:140px;left:-50px;bottom:-70px;"></span>

                    <div class="ph-photo-wrap">
                        @if ($account->Image)
                            <img src="{{ asset('Admin_Images/' . $account->Image) }}" class="avatar-xl" id="heroAvatarImg" alt="{{ $account->Name }}">
                        @else
                            <span class="avatar-xl" id="heroAvatarInitials">{{ strtoupper(substr($account->Name ?? 'U', 0, 2)) }}</span>
                        @endif
                        <button type="button" class="ph-photo-edit" id="photoTrigger" title="Change profile photo">
                            <i class="bi bi-camera-fill"></i>
                        </button>
                    </div>

                    <h4 class="ph-name">{{ $account->Name }}</h4>
                    <div class="ph-sub">{{ $roleLabel }} · @{{ $account->Username }}</div>

                    <div class="ph-badges">
                        <span class="badge-soft"><i class="bi bi-envelope"></i>{{ $account->Email }}</span>
                        <span class="badge-soft"><i class="bi bi-telephone"></i>{{ $account->Contactno }}</span>
                    </div>
                </div>

                <form id="photoForm" enctype="multipart/form-data" class="d-none">
                    @csrf
                    <input type="file" name="Image" id="photoInput" accept="image/jpeg,image/png,image/jpg">
                </form>

                <div class="row g-4">
                    {{-- ===== Account details ===== --}}
                    <div class="col-lg-6">
                        <div class="idc-card h-100 anim-fade-up anim-d1">
                            <div class="card-head">
                                <div>
                                    <h6><i class="bi bi-person-vcard me-2 text-gradient"></i>Account Details</h6>
                                    <div class="sub">Update your name, email and contact number</div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <form id="infoForm" novalidate>
                                    @csrf
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label">Full Name <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-person"></i>
                                                <input type="text" name="Name" required class="form-control" value="{{ $account->Name }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Username</label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-at"></i>
                                                <input type="text" class="form-control" value="{{ $account->Username }}" disabled>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Email Address <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-envelope"></i>
                                                <input type="email" name="Email" required class="form-control" value="{{ $account->Email }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Contact No <span class="req">*</span></label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-telephone"></i>
                                                <input type="text" name="ContactNo" required maxlength="11" class="form-control" value="{{ $account->Contactno }}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label">Role</label>
                                            <div class="input-icon-group">
                                                <i class="bi bi-shield-check"></i>
                                                <input type="text" class="form-control" value="{{ $roleLabel }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-end mt-4">
                                        <button type="submit" class="btn btn-gradient">
                                            <i class="bi bi-check2-circle me-1"></i>Save Details
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- ===== Change password ===== --}}
                    <div class="col-lg-6">
                        <div class="idc-card h-100 anim-fade-up anim-d2">
                            <div class="card-head">
                                <div>
                                    <h6><i class="bi bi-shield-lock me-2 text-gradient"></i>Change Password</h6>
                                    <div class="sub">Use a strong password between 8 and 15 characters</div>
                                </div>
                                <span class="badge-soft badge-soft-primary"><span class="dot"></span>Secure</span>
                            </div>
                            <div class="card-inner">
                                <form id="passwordForm" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Current Password <span class="req">*</span></label>
                                        <div class="input-icon-group">
                                            <i class="bi bi-key"></i>
                                            <input type="password" name="CurrentPassword" required class="form-control" placeholder="Enter current password">
                                            <button type="button" class="toggle-password" tabindex="-1"><i class="bi bi-eye"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">New Password <span class="req">*</span></label>
                                        <div class="input-icon-group">
                                            <i class="bi bi-shield-lock"></i>
                                            <input type="password" name="NewPassword" required minlength="8" maxlength="15" class="form-control" placeholder="8–15 characters">
                                            <button type="button" class="toggle-password" tabindex="-1"><i class="bi bi-eye"></i></button>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirm New Password <span class="req">*</span></label>
                                        <div class="input-icon-group">
                                            <i class="bi bi-shield-check"></i>
                                            <input type="password" name="NewPassword_confirmation" required class="form-control" placeholder="Re-type new password">
                                            <button type="button" class="toggle-password" tabindex="-1"><i class="bi bi-eye"></i></button>
                                        </div>
                                    </div>
                                    <div class="doc-note info" style="margin: 0 0 18px;">
                                        <i class="bi bi-info-circle me-1"></i>You'll continue to use your current username to sign in — only the password changes.
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-gradient">
                                            <i class="bi bi-shield-lock me-1"></i>Update Password
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

            // ---- Profile photo (click avatar edit → auto-submit) ----
            $('#photoTrigger').click(function() {
                $('#photoInput').click();
            });

            $('#photoInput').change(function() {
                if (!this.files || !this.files[0]) return;

                var formData = new FormData(document.getElementById('photoForm'));
                $('#photoTrigger').html('<span class="spinner-border spinner-border-sm"></span>');

                $.ajax({
                    url: @json(route('profile.updatephoto')),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        var img = $('<img>').attr({ src: response.image, id: 'heroAvatarImg' }).addClass('avatar-xl');
                        $('#heroAvatarImg, #heroAvatarInitials').replaceWith(img);
                        $('#photoTrigger').html('<i class="bi bi-camera-fill"></i>');
                        Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2200, showConfirmButton: false });
                    },
                    error: function(xhr) {
                        $('#photoTrigger').html('<i class="bi bi-camera-fill"></i>');
                        var msg = (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.Image)
                            ? xhr.responseJSON.errors.Image[0]
                            : 'Something went wrong. Please try again.';
                        Swal.fire({ icon: 'error', title: 'Error', text: msg });
                    }
                });
            });

            // ---- Account details form ----
            $('#infoForm').submit(function(e) {
                e.preventDefault();
                var btn = $(this).find('button[type="submit"]');
                var original = btn.html();
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving…');

                $.ajax({
                    url: @json(route('profile.updateinfo')),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        btn.prop('disabled', false).html(original);
                        Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2200, showConfirmButton: false });
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(original);
                        showAjaxErrors(xhr);
                    }
                });
            });

            // ---- Password form ----
            $('#passwordForm').submit(function(e) {
                e.preventDefault();
                var btn = $(this).find('button[type="submit"]');
                var original = btn.html();
                btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Updating…');
                var form = this;

                $.ajax({
                    url: @json(route('profile.updatepassword')),
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        btn.prop('disabled', false).html(original);
                        form.reset();
                        Swal.fire({ icon: 'success', title: 'Success', text: response.message, timer: 2200, showConfirmButton: false });
                    },
                    error: function(xhr) {
                        btn.prop('disabled', false).html(original);
                        showAjaxErrors(xhr);
                    }
                });
            });

            function showAjaxErrors(xhr) {
                if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                    var errorMessage = '';
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        errorMessage += value[0] + '<br>';
                    });
                    Swal.fire({ icon: 'error', title: 'Validation Error', html: errorMessage });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Something went wrong. Please try again.' });
                }
            }
        });
    </script>
@endpush
