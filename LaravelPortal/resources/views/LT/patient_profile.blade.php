@extends('app')

@section('pagetitle', 'Patient Profile')

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
                'title' => 'Patient Profile',
                'crumb' => 'Patient Journey Tracker',
                'userName' => session('Admin_Auth_Session') ?? session('LT_Auth_Session') ?? session('Path_Auth_Session'),
                'avatarFile' => session('Admin_Role_Image') ?? session('LT_Role_Image') ?? session('Path_Role_image'),
            ])

            <div class="idc-content">

                {{-- ===== Profile header ===== --}}
                <div class="profile-hero anim-fade-up mb-4">
                    <span class="hero-deco" style="width:220px;height:220px;right:-60px;top:-110px;"></span>
                    <span class="hero-deco" style="width:140px;height:140px;left:-50px;bottom:-70px;"></span>

                    <span class="avatar-xl">{{ strtoupper(substr($patient->Name ?? 'P', 0, 2)) }}</span>

                    <h4 class="ph-name">{{ $patient->Name }}</h4>
                    <div class="ph-sub">Patient · IDC-{{ str_pad($patient->Id, 5, '0', STR_PAD_LEFT) }}</div>

                    <div class="ph-badges">
                        <span class="badge-soft"><i class="bi bi-upc-scan"></i>#{{ $patient->Sampleno }}</span>
                        @if ($patient->Result === 'Positive')
                            <span class="badge-soft"><span class="dot" style="background:#fda4af;"></span>IDC Positive</span>
                        @elseif ($patient->Result === 'Negative')
                            <span class="badge-soft"><span class="dot" style="background:#6ee7b7;"></span>IDC Negative</span>
                        @else
                            <span class="badge-soft"><span class="dot" style="background:#fcd34d;"></span>Result Pending</span>
                        @endif
                        @if ($patient->treated == '1')
                            <span class="badge-soft"><i class="bi bi-check2-circle"></i>Treated</span>
                        @else
                            <span class="badge-soft"><i class="bi bi-hourglass-split"></i>In Review Queue</span>
                        @endif
                    </div>

                    <div class="ph-actions">
                        <a href="{{ route('patient.receipt', ['id' => $patient->Id]) }}" class="btn btn-light btn-sm fw-bold">
                            <i class="bi bi-receipt me-1"></i>Registration Receipt
                        </a>
                        <a href="{{ route('patient.label', ['id' => $patient->Id]) }}" class="btn btn-outline-light btn-sm fw-bold">
                            <i class="bi bi-upc me-1"></i>Barcode Label
                        </a>
                        @if ($patient->treated == '1')
                            <a href="{{ route('patient.report', ['id' => $patient->Id]) }}" class="btn btn-ai btn-sm">
                                <i class="bi bi-file-earmark-medical me-1"></i>Diagnosis Report
                            </a>
                        @endif
                    </div>
                </div>

                <div class="row g-4">
                    {{-- ===== Care journey timeline ===== --}}
                    <div class="col-lg-5">
                        <div class="idc-card h-100 anim-fade-up anim-d1">
                            <div class="card-head">
                                <div>
                                    <h6><i class="bi bi-signpost-2 me-2 text-gradient"></i>Care Journey</h6>
                                    <div class="sub">Live tracking of this patient's diagnostic pathway</div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="timeline">

                                    <div class="tl-item done">
                                        <span class="tl-dot"><i class="bi bi-check-lg"></i></span>
                                        <div class="tl-title">Sample Registered</div>
                                        <div class="tl-text">Sample #{{ $patient->Sampleno }} registered by {{ $patient->Addedby }} · confirmation email sent to patient.</div>
                                        <div class="tl-time"><i class="bi bi-clock me-1"></i>{{ $patient->created_at ? $patient->created_at->format('d M Y · h:i A') : '—' }}</div>
                                    </div>

                                    <div class="tl-item {{ $patient->treated == '1' ? 'done' : 'current' }}">
                                        <span class="tl-dot"><i class="bi {{ $patient->treated == '1' ? 'bi-check-lg' : 'bi-arrow-repeat' }}"></i></span>
                                        <div class="tl-title">Laboratory Processing</div>
                                        <div class="tl-text">
                                            @if ($patient->treated == '1')
                                                Histopathology slide prepared and analyzed with AI assistance.
                                            @else
                                                Sample is in the pathology review queue — awaiting histopathology analysis.
                                            @endif
                                        </div>
                                    </div>

                                    <div class="tl-item {{ $patient->treated == '1' ? 'done' : 'pending' }}">
                                        <span class="tl-dot"><i class="bi bi-check-lg"></i></span>
                                        <div class="tl-title">Diagnostic Result Recorded</div>
                                        <div class="tl-text">
                                            @if ($patient->treated == '1')
                                                Result <strong>{{ $patient->Result }}</strong> recorded by Dr. {{ $patient->Doctorby }}.
                                            @else
                                                The pathologist will record the IDC result after review.
                                            @endif
                                        </div>
                                        @if ($patient->treated == '1')
                                            <div class="tl-time"><i class="bi bi-clock me-1"></i>{{ $patient->updated_at ? $patient->updated_at->format('d M Y · h:i A') : '—' }}</div>
                                        @endif
                                    </div>

                                    <div class="tl-item {{ $patient->treated == '1' ? 'done' : 'pending' }}">
                                        <span class="tl-dot"><i class="bi bi-check-lg"></i></span>
                                        <div class="tl-title">Patient Notified · Report Ready</div>
                                        <div class="tl-text">
                                            @if ($patient->treated == '1')
                                                Result emailed to {{ $patient->Email }} — the diagnosis report is ready to print.
                                            @else
                                                The patient will automatically receive the result by email.
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ===== Details + barcode ===== --}}
                    <div class="col-lg-7">
                        <div class="idc-card anim-fade-up anim-d2 mb-4">
                            <div class="card-head">
                                <div>
                                    <h6><i class="bi bi-person-vcard me-2 text-gradient"></i>Patient Details</h6>
                                    <div class="sub">Registered demographic and contact information</div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="row g-3">
                                    <div class="col-sm-6"><div class="info-tile"><div class="it-label">Full Name</div><div class="it-value">{{ $patient->Name }}</div></div></div>
                                    <div class="col-sm-6"><div class="info-tile"><div class="it-label">Sample No</div><div class="it-value">#{{ $patient->Sampleno }}</div></div></div>
                                    <div class="col-sm-6"><div class="info-tile"><div class="it-label">Email</div><div class="it-value">{{ $patient->Email }}</div></div></div>
                                    <div class="col-sm-6"><div class="info-tile"><div class="it-label">Contact No</div><div class="it-value">{{ $patient->Contactno }}</div></div></div>
                                    <div class="col-sm-6"><div class="info-tile"><div class="it-label">Registered By (LT)</div><div class="it-value">{{ $patient->Addedby }}</div></div></div>
                                    <div class="col-sm-6"><div class="info-tile"><div class="it-label">Pathologist</div><div class="it-value">{{ $patient->Doctorby ? 'Dr. ' . $patient->Doctorby : '—' }}</div></div></div>
                                </div>

                                <div class="text-center mt-4">
                                    <div class="barcode-card">
                                        <svg id="profileBarcode"></svg>
                                    </div>
                                    <div class="small text-muted fw-semibold mt-2">
                                        <i class="bi bi-upc-scan me-1"></i>Scan to identify sample ·
                                        <a href="{{ route('patient.label', ['id' => $patient->Id]) }}" class="fw-bold text-decoration-none">print label</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($patient->treated == '1' && $patient->Image)
                            <div class="idc-card anim-fade-up anim-d3">
                                <div class="card-head">
                                    <div>
                                        <h6><i class="bi bi-file-earmark-medical me-2 text-gradient"></i>Histopathology Image</h6>
                                        <div class="sub">Slide image attached with the diagnostic result</div>
                                    </div>
                                </div>
                                <div class="card-inner text-center">
                                    <img src="{{ asset('Patient_Images/' . $patient->Image) }}" alt="Histopathology slide"
                                        class="pathology-img" style="max-height: 340px;">
                                </div>
                            </div>
                        @endif
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
        JsBarcode('#profileBarcode', @json($patient->Sampleno), {
            format: 'CODE128',
            width: 2,
            height: 62,
            margin: 0,
            displayValue: true,
            fontSize: 14,
            font: 'Plus Jakarta Sans',
            fontOptions: 'bold',
            textMargin: 6
        });
    </script>
@endpush
