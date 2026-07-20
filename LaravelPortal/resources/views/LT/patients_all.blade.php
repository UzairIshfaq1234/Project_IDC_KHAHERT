@extends('app')

@section('pagetitle', 'All Patients')

@section('content')
    <div class="idc-shell">

        @include('LT.LT_layout.LT_navbar')

        <div class="idc-main">

            @include('layouts.topbar', [
                'title' => 'All Patients',
                'crumb' => 'Lab Technician · Patients',
                'userName' => session('LT_Auth_Session'),
                'avatarFile' => session('LT_Role_Image'),
            ])

            <div class="idc-content">

                <div class="idc-card anim-fade-up">
                    <div class="table-toolbar">
                        <div>
                            <h6 class="mb-0 fw-bolder"><i class="bi bi-clipboard2-data me-2 text-gradient"></i>Patient Registry</h6>
                            <div class="text-muted small fw-semibold">{{ count($all_patient_records) }} registered samples</div>
                        </div>
                        <div class="d-flex align-items-center gap-2 ms-auto flex-wrap">
                            <button class="btn btn-soft btn-sm" data-export-table="#patientTable" data-export-name="idc-patients">
                                <i class="bi bi-download me-1"></i>CSV
                            </button>
                            <button class="btn btn-soft btn-sm" data-print-page>
                                <i class="bi bi-printer me-1"></i>Print
                            </button>
                            <a href="{{ route('patient.add') }}" class="btn btn-gradient btn-sm">
                                <i class="bi bi-plus-lg me-1"></i>Add Patient
                            </a>
                            <div class="search-box">
                                <i class="bi bi-search"></i>
                                <input type="text" class="form-control form-control-sm" placeholder="Search patients…"
                                    data-table-search="#patientTable">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-modern" id="patientTable">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Sample No</th>
                                    <th>Contact</th>
                                    <th>Added By</th>
                                    <th>Result</th>
                                    <th>Status</th>
                                    <th data-no-export>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($all_patient_records as $record)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="avatar avatar-grad-{{ ($loop->index % 5) + 1 }}">{{ strtoupper(substr($record->Name ?? 'P', 0, 2)) }}</span>
                                                <div>
                                                    <div class="cell-title">{{ $record->Name }}</div>
                                                    <div class="cell-sub">{{ $record->Email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge-soft badge-soft-violet">#{{ $record->Sampleno }}</span></td>
                                        <td>{{ $record->Contactno }}</td>
                                        <td>{{ $record->Addedby }}</td>
                                        <td>
                                            @if ($record->Result === 'Positive')
                                                <span class="badge-soft badge-soft-danger"><span class="dot"></span>Positive</span>
                                            @elseif ($record->Result === 'Negative')
                                                <span class="badge-soft badge-soft-success"><span class="dot"></span>Negative</span>
                                            @else
                                                <span class="badge-soft badge-soft-warning"><span class="dot"></span>Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($record->treated == '1')
                                                <span class="badge-soft badge-soft-info">Treated</span>
                                            @else
                                                <span class="badge-soft badge-soft-warning">In queue</span>
                                            @endif
                                        </td>
                                        <td data-no-export>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('patient.profile', ['id' => $record->Id]) }}"
                                                    class="btn-icon edit" title="Patient profile & tracking">
                                                    <i class="bi bi-person-lines-fill"></i>
                                                </a>
                                                <a href="{{ route('patient.receipt', ['id' => $record->Id]) }}"
                                                    class="btn-icon edit" title="Registration receipt">
                                                    <i class="bi bi-receipt"></i>
                                                </a>
                                                <a href="{{ route('patient.label', ['id' => $record->Id]) }}"
                                                    class="btn-icon edit" title="Print barcode label">
                                                    <i class="bi bi-upc"></i>
                                                </a>
                                                @if ($record->treated == '1')
                                                    <a href="{{ route('patient.report', ['id' => $record->Id]) }}"
                                                        class="btn-icon edit" title="Diagnosis report">
                                                        <i class="bi bi-file-earmark-medical"></i>
                                                    </a>
                                                @endif
                                                <button type="button" class="btn-icon edit edit-button" title="Edit"
                                                    data-record="{{ json_encode($record) }}"
                                                    data-bs-toggle="modal" data-bs-target="#editPatientModal">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
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

    {{-- ===== Edit Patient modal (single, shared) ===== --}}
    <div id="editPatientModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="mi"><i class="bi bi-pencil-square"></i></span>
                        Update Patient
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="{{ route('patient.updatepatient') }}" method="POST" enctype="multipart/form-data" id="form" novalidate>
                    {{ csrf_field() }}

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label" for="Name">Name <span class="req">*</span></label>
                                <input type="text" name="Name" required placeholder="Enter Name" class="form-control" id="Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="Email">Email <span class="req">*</span></label>
                                <input type="text" name="Email" required placeholder="Enter Email" class="form-control" id="Email">
                            </div>
                            <div class="col-12">
                                <label class="form-label" for="Contactno">Contact No <span class="req">*</span></label>
                                <input id="Contactno" type="text" name="Contactno" maxlength="11"
                                    placeholder="Enter Contact No" required class="form-control">
                            </div>
                        </div>
                        <input type="hidden" name="Id" id="field-4">
                        <div class="small text-muted fw-semibold mt-3">
                            <i class="bi bi-envelope-check me-1"></i>The patient will receive an email about this update.
                        </div>
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
            $('.edit-button').click(function() {
                var recordData = $(this).data('record');
                $('#Name').val(recordData.Name);
                $('#Email').val(recordData.Email);
                $('#Contactno').val(recordData.Contactno);

                $('#field-4').val(recordData.Id);
            });

            $('#form').submit(function(e) {
                e.preventDefault();
                var routter = @json(route('patient.updatepatient'));

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
