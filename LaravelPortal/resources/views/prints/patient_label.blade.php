@extends('app')

@section('pagetitle', 'Barcode Label')
@section('bodyclass', 'print-body')

@section('content')

    <div class="print-toolbar no-print">
        <a href="javascript:history.back()" class="btn btn-soft btn-sm"><i class="bi bi-arrow-left me-1"></i>Back</a>
        <a href="{{ route('patient.profile', ['id' => $patient->Id]) }}" class="btn btn-soft btn-sm"><i class="bi bi-person-lines-fill me-1"></i>Profile</a>
        <button class="btn btn-gradient btn-sm" data-print-page><i class="bi bi-printer me-1"></i>Print Label</button>
    </div>

    <div class="label-doc">
        <div class="lb-brand"><i class="bi bi-activity me-1"></i>I D C LAB</div>
        <div class="lb-name">{{ $patient->Name }}</div>
        <div class="lb-meta">
            Reg: {{ $patient->created_at ? $patient->created_at->format('d M Y') : '—' }}
            · ID: IDC-{{ str_pad($patient->Id, 5, '0', STR_PAD_LEFT) }}
        </div>
        <svg id="labelBarcode" class="mt-2"></svg>
    </div>

    <p class="text-center no-print small fw-semibold" style="color: var(--idc-muted);">
        <i class="bi bi-scissors me-1"></i>Cut along the dashed line and paste the label on the sample container.
    </p>
@endsection

@push('scripts')
    <script>
        JsBarcode('#labelBarcode', @json($patient->Sampleno), {
            format: 'CODE128',
            width: 2.2,
            height: 70,
            margin: 0,
            displayValue: true,
            fontSize: 15,
            font: 'Plus Jakarta Sans',
            fontOptions: 'bold',
            textMargin: 6
        });
    </script>
@endpush
