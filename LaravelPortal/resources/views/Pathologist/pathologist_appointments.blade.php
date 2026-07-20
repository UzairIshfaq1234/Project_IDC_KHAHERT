@extends('app')

@section('pagetitle', 'Appointments')

@section('content')
    <div class="idc-shell">

        @include('Pathologist.pathologist_layout.pathologist_navbar')

        <div class="idc-main">

            @include('layouts.topbar', [
                'title' => 'Patient Appointments',
                'crumb' => 'Pathologist · Clinical Work',
                'userName' => session('Path_Auth_Session'),
                'avatarFile' => session('Path_Role_image'),
            ])

            <div class="idc-content">

                <div class="idc-card anim-fade-up">
                    <div class="table-toolbar">
                        <div>
                            <h6 class="mb-0 fw-bolder"><i class="bi bi-calendar2-check me-2 text-gradient"></i>Diagnostic Review Queue</h6>
                            <div class="text-muted small fw-semibold">{{ count($patient_appointment) }} case{{ count($patient_appointment) == 1 ? '' : 's' }} awaiting a result</div>
                        </div>
                        <div class="d-flex align-items-center gap-2 ms-auto flex-wrap">
                            <a href="http://127.0.0.1:5000/" target="_blank" class="btn btn-ai btn-sm">
                                <i class="bi bi-cpu me-1"></i>AI Detection Engine
                            </a>
                            <div class="search-box">
                                <i class="bi bi-search"></i>
                                <input type="text" class="form-control form-control-sm" placeholder="Search queue…"
                                    data-table-search="#appointmentTable">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-modern" id="appointmentTable">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Sample No</th>
                                    <th>Contact</th>
                                    <th>Registered By</th>
                                    <th data-no-export>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($patient_appointment as $patient_appointmentdata)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="avatar avatar-grad-{{ ($loop->index % 5) + 1 }}">{{ strtoupper(substr($patient_appointmentdata->Name ?? 'P', 0, 2)) }}</span>
                                                <div>
                                                    <div class="cell-title">{{ $patient_appointmentdata->Name }}</div>
                                                    <div class="cell-sub">{{ $patient_appointmentdata->Email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge-soft badge-soft-violet">#{{ $patient_appointmentdata->Sampleno }}</span></td>
                                        <td>{{ $patient_appointmentdata->Contactno }}</td>
                                        <td>{{ $patient_appointmentdata->Addedby }}</td>
                                        <td data-no-export>
                                            <div class="d-flex gap-2 align-items-center">
                                                <a href="{{ route('patient.profile', ['id' => $patient_appointmentdata->Id]) }}"
                                                    class="btn-icon edit" title="Patient profile & tracking">
                                                    <i class="bi bi-person-lines-fill"></i>
                                                </a>
                                                <button type="button" class="btn btn-gradient btn-sm edit-button"
                                                    data-record="{{ json_encode($patient_appointmentdata) }}"
                                                    data-bs-toggle="modal" data-bs-target="#appointmentModal">
                                                    <i class="bi bi-clipboard2-check me-1"></i>Enter Result
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr data-empty-row>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <div class="es-icon"><i class="bi bi-check2-all"></i></div>
                                                <h6>All caught up!</h6>
                                                <p>There are no pending appointments right now.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
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

    {{-- ===== Result entry modal (single, shared) ===== --}}
    <div id="appointmentModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="mi"><i class="bi bi-clipboard2-check"></i></span>
                        Record Diagnostic Result
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('Path.updateAppointment') }}" method="POST" enctype="multipart/form-data" id="form" novalidate>
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="Sampleno">Sample No <span class="req">*</span></label>
                                <input disabled type="text" name="Sampleno" required class="form-control" id="Sampleno">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">IDC Result <span class="req">*</span></label>
                                <select name="Result" required class="form-select">
                                    <option selected disabled>Select Result</option>
                                    <option value="Positive">Positive — IDC detected</option>
                                    <option value="Negative">Negative — no IDC detected</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Histopathology Image <span class="req">*</span></label>
                                <div class="file-drop">
                                    <input id="Image" type="file" name="Image" accept="image/jpeg,image/png,image/jpg" required hidden>
                                    <i class="bi bi-file-earmark-medical"></i>
                                    <div class="fw-bold mt-2">Drop the pathology image here or click to browse</div>
                                    <div class="fd-hint">JPEG / PNG · up to 3 MB</div>
                                    <div class="fd-name"></div>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="Id" id="field-4">
                        <div class="small text-muted fw-semibold mt-3">
                            <i class="bi bi-envelope-check me-1"></i>The patient will automatically receive their result by email.
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-soft" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-gradient">
                            <i class="bi bi-check2-circle me-1"></i>Save Result
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
            $('.edit-button').click(function() {
                var recordData = $(this).data('record');
                $('#Sampleno').val(recordData.Sampleno);

                $('#field-4').val(recordData.Id);
            });

            $('#form').submit(function(e) {
                e.preventDefault();
                var routter = @json(route('Path.updateAppointment'));

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
                        submitBtn.prop('disabled', false).html('<i class="bi bi-check2-circle me-1"></i>Save Result');
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
