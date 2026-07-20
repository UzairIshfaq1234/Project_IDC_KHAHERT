@extends('app')

@section('pagetitle', 'Diagnosis Report')
@section('bodyclass', 'print-body')

@section('content')

    <div class="print-toolbar no-print">
        <a href="javascript:history.back()" class="btn btn-soft btn-sm"><i class="bi bi-arrow-left me-1"></i>Back</a>
        <a href="{{ route('patient.profile', ['id' => $patient->Id]) }}" class="btn btn-soft btn-sm"><i class="bi bi-person-lines-fill me-1"></i>Profile</a>
        <a href="{{ route('patient.receipt', ['id' => $patient->Id]) }}" class="btn btn-soft btn-sm"><i class="bi bi-receipt me-1"></i>Receipt</a>
        <button class="btn btn-gradient btn-sm" data-print-page><i class="bi bi-printer me-1"></i>Print Report</button>
    </div>

    <div class="print-doc {{ $patient->Result === 'Positive' ? 'doc-positive' : 'doc-negative' }}">
        <div class="doc-band"></div>

        <div class="doc-head">
            <div class="doc-brand">
                <div class="brand-icon"><i class="bi bi-activity"></i></div>
                <div>
                    <strong>I D C</strong>
                    <small>Invasive Ductal Carcinoma Diagnostic Center</small>
                </div>
            </div>
            <div class="doc-meta">
                <div class="doc-no">REPORT № IDC-R-{{ str_pad($patient->Id, 5, '0', STR_PAD_LEFT) }}</div>
                <div>Result Recorded: {{ $patient->updated_at ? $patient->updated_at->format('d M Y · h:i A') : '—' }}</div>
                <div>Printed: {{ now()->format('d M Y · h:i A') }}</div>
            </div>
        </div>

        <div class="doc-title">
            <h5>Histopathology Diagnosis Report</h5>
        </div>

        <div class="doc-section">
            <div class="sec-label"><i class="bi bi-person-vcard"></i> Patient Information</div>
            <div class="doc-grid">
                <div class="doc-field"><div class="df-label">Patient Name</div><div class="df-value">{{ $patient->Name }}</div></div>
                <div class="doc-field"><div class="df-label">Sample No</div><div class="df-value">#{{ $patient->Sampleno }}</div></div>
                <div class="doc-field"><div class="df-label">Patient ID</div><div class="df-value">IDC-{{ str_pad($patient->Id, 5, '0', STR_PAD_LEFT) }}</div></div>
                <div class="doc-field"><div class="df-label">Contact No</div><div class="df-value">{{ $patient->Contactno }}</div></div>
                <div class="doc-field"><div class="df-label">Sample Collected</div><div class="df-value">{{ $patient->created_at ? $patient->created_at->format('d M Y') : '—' }}</div></div>
                <div class="doc-field"><div class="df-label">Registered By (LT)</div><div class="df-value">{{ $patient->Addedby }}</div></div>
            </div>
        </div>

        <div class="result-banner {{ $patient->Result === 'Positive' ? 'positive' : 'negative' }}">
            <div class="rb-label">Diagnostic Decision — IDC Screening</div>
            <div class="rb-value">
                <i class="bi {{ $patient->Result === 'Positive' ? 'bi-exclamation-triangle' : 'bi-check-circle' }} me-2"></i>{{ strtoupper($patient->Result) }}
            </div>
            <div class="rb-note">
                @if ($patient->Result === 'Positive')
                    Invasive ductal carcinoma indicators detected. Please contact the hospital immediately to begin the treatment pathway.
                @else
                    No invasive ductal carcinoma indicators detected in the examined sample.
                @endif
            </div>
        </div>

        <div class="doc-section">
            <div class="sec-label"><i class="bi bi-clipboard2-pulse"></i> Examination Details</div>
            <div class="doc-grid">
                <div class="doc-field"><div class="df-label">Examination</div><div class="df-value">Histopathology — IDC Screening</div></div>
                <div class="doc-field"><div class="df-label">Method</div><div class="df-value">AI-assisted deep-learning microscopy</div></div>
                <div class="doc-field"><div class="df-label">Reviewing Pathologist</div><div class="df-value">Dr. {{ $patient->Doctorby }}</div></div>
            </div>
        </div>

        @if ($patient->Image)
            <div class="doc-section">
                <div class="sec-label"><i class="bi bi-file-earmark-medical"></i> Histopathology Slide</div>
                <div style="text-align:center;">
                    <img src="{{ asset('Patient_Images/' . $patient->Image) }}" alt="Histopathology slide"
                        style="max-height: 260px; max-width: 100%; border-radius: 12px; border: 1px solid #e5e9f2;">
                </div>
            </div>
        @endif

        <div class="doc-barcode">
            <svg id="reportBarcode"></svg>
            <div class="bc-hint">Sample identification</div>
        </div>

        <div class="doc-note info">
            <strong>Disclaimer:</strong> This report was produced with the assistance of an AI-based screening model and
            verified by a qualified pathologist. It should be interpreted alongside clinical findings.
            Please consult your physician for treatment decisions.
        </div>

        <div class="doc-sign">
            <div class="sig">
                <div class="sig-line"></div>
                <div class="sig-name">{{ $patient->Addedby }}</div>
                <div class="sig-role">Laboratory Technician</div>
            </div>
            <div class="sig">
                <div class="sig-line"></div>
                <div class="sig-name">Dr. {{ $patient->Doctorby }}</div>
                <div class="sig-role">Consultant Pathologist</div>
            </div>
        </div>

        <div class="doc-foot">
            <span><span class="fw-white">IDC Diagnostic Center</span> · AI-assisted histopathology</span>
            <span>Generated by IDC Portal · {{ now()->format('d M Y') }}</span>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        JsBarcode('#reportBarcode', @json($patient->Sampleno), {
            format: 'CODE128',
            width: 2.1,
            height: 58,
            margin: 0,
            displayValue: true,
            fontSize: 14,
            font: 'Plus Jakarta Sans',
            fontOptions: 'bold',
            textMargin: 6
        });
    </script>
@endpush
