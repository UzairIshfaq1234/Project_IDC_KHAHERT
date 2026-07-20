@extends('app')

@section('pagetitle', 'All Logins')

@section('content')
    <div class="idc-shell">

        @include('admin.admin_layout.admin_navbar')

        <div class="idc-main">

            @include('layouts.topbar', [
                'title' => 'All Logins',
                'crumb' => 'Administrator · Team Management',
                'userName' => session('Admin_Auth_Session'),
                'avatarFile' => session('Admin_Role_Image'),
            ])

            <div class="idc-content">

                <div class="idc-card anim-fade-up">
                    <div class="table-toolbar">
                        <div>
                            <h6 class="mb-0 fw-bolder"><i class="bi bi-people me-2 text-gradient"></i>Team Logins</h6>
                            <div class="text-muted small fw-semibold">{{ count($all_admin_records) }} registered accounts</div>
                        </div>
                        <div class="d-flex align-items-center gap-2 ms-auto flex-wrap">
                            <button class="btn btn-soft btn-sm" data-export-table="#adminTable" data-export-name="idc-logins">
                                <i class="bi bi-download me-1"></i>CSV
                            </button>
                            <button class="btn btn-soft btn-sm" data-print-page>
                                <i class="bi bi-printer me-1"></i>Print
                            </button>
                            <a href="{{ route('admin.add') }}" class="btn btn-gradient btn-sm">
                                <i class="bi bi-plus-lg me-1"></i>Add Login
                            </a>
                            <div class="search-box">
                                <i class="bi bi-search"></i>
                                <input type="text" class="form-control form-control-sm" placeholder="Search team…"
                                    data-table-search="#adminTable">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-modern" id="adminTable">
                            <thead>
                                <tr>
                                    <th>Member</th>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Contact</th>
                                    <th>Password</th>
                                    <th data-no-export>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_admin_records as $record)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                @if ($record->Image)
                                                    <img src="{{ asset('Admin_Images/' . $record->Image) }}" class="avatar" alt="{{ $record->Name }}">
                                                @else
                                                    <span class="avatar avatar-grad-{{ ($loop->index % 5) + 1 }}">{{ strtoupper(substr($record->Name ?? 'U', 0, 2)) }}</span>
                                                @endif
                                                <div>
                                                    <div class="cell-title">{{ $record->Name }}</div>
                                                    <div class="cell-sub">{{ $record->Email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="fw-bold">{{ $record->Username }}</span></td>
                                        <td>
                                            @if ($record->Role == 1)
                                                <span class="badge-soft badge-soft-primary"><i class="bi bi-shield-check"></i>Admin</span>
                                            @elseif ($record->Role == 2)
                                                <span class="badge-soft badge-soft-success"><i class="bi bi-eyedropper"></i>Lab Technician</span>
                                            @else
                                                <span class="badge-soft badge-soft-violet"><i class="bi bi-clipboard2-pulse"></i>Pathologist</span>
                                            @endif
                                        </td>
                                        <td>{{ $record->Contactno }}</td>
                                        <td>
                                            <span class="pw-mask" data-pw="{{ $record->Password }}">••••••••</span>
                                            <button type="button" class="btn-icon ms-1 pw-reveal" title="Show / hide password" data-no-export>
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                        <td data-no-export>
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn-icon edit edit-button" title="Edit"
                                                    data-record="{{ json_encode($record) }}"
                                                    data-bs-toggle="modal" data-bs-target="#editAdminModal">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                <a href="{{ route('admin.deladmin', ['id' => $record->Id]) }}"
                                                    class="btn-icon delete delete-link-admin" title="Delete"
                                                    data-id="{{ $record->Id }}">
                                                    <i class="bi bi-trash3"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="empty-state" data-search-empty style="display:none;">
                            <div class="es-icon"><i class="bi bi-search"></i></div>
                            <h6>No matches found</h6>
                            <p>Try a different search term.</p>
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

    {{-- ===== Edit Login modal (single, shared) ===== --}}
    <div id="editAdminModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="mi"><i class="bi bi-pencil-square"></i></span>
                        Update Login
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('admin.updateadmin') }}" method="POST" enctype="multipart/form-data" id="form" novalidate>
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="Name">Name <span class="req">*</span></label>
                                <input type="text" name="Name" required placeholder="Enter Name" class="form-control" id="Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="Username">Username <span class="req">*</span></label>
                                <input type="text" name="Username" required placeholder="Enter Unique Username"
                                    class="form-control" id="Username">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="Email">Email Address <span class="req">*</span></label>
                                <input type="email" name="Email" required placeholder="Enter Email" class="form-control" id="Email">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="Password">Password <span class="req">*</span></label>
                                <input id="Password" type="text" name="Password" placeholder="Password" required class="form-control">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="Role">Role <span class="req">*</span></label>
                                <select id="Role" name="Role" required class="form-select">
                                    <option selected disabled>Select Role</option>
                                    <option value="1">Admin</option>
                                    <option value="2">Laboratory Technician</option>
                                    <option value="3">Pathologist</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="Contactno">Contact No <span class="req">*</span></label>
                                <input id="Contactno" type="text" name="ContactNo" maxlength="11"
                                    placeholder="Enter Contact No" required class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="Id" id="field-4">
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient">
                            <i class="bi bi-check2-circle me-1"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            // Password reveal toggle per row
            $('.pw-reveal').click(function() {
                var mask = $(this).siblings('.pw-mask');
                var showing = mask.data('showing');
                mask.text(showing ? '••••••••' : mask.data('pw')).data('showing', !showing);
                $(this).find('i').attr('class', showing ? 'bi bi-eye' : 'bi bi-eye-slash');
            });

            $('.delete-link-admin').click(function(event) {
                event.preventDefault();

                var deleteUrl = $(this).attr('href');
                var recordId = $(this).data('id');

                Swal.fire({
                    title: 'Delete Confirmation',
                    text: 'Are you sure you want to delete this record?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteRecord(deleteUrl, recordId);
                    }
                });
            });

            function deleteRecord(url, id) {
                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.toast_message,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    },
                    error: function(xhr) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Something went wrong. Please try again.',
                        });
                    }
                });
            }

            $('.edit-button').click(function() {
                var recordData = $(this).data('record');
                $('#Name').val(recordData.Name);
                $('#Username').val(recordData.Username);
                $('#Email').val(recordData.Email);
                $('#Password').val(recordData.Password);
                $('#Role').val(recordData.Role);
                $('#Contactno').val(recordData.Contactno);

                $('#field-4').val(recordData.Id);
            });

            $('#form').submit(function(e) {
                e.preventDefault();
                var routter = @json(route('admin.updateadmin'));

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
