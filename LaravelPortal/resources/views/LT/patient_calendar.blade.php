@extends('app')

@section('pagetitle', 'Submissions Calendar')

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
                'title' => 'Submissions Calendar',
                'crumb' => 'Patient Sample Intake',
                'userName' => session('Admin_Auth_Session') ?? session('LT_Auth_Session') ?? session('Path_Auth_Session'),
                'avatarFile' => session('Admin_Role_Image') ?? session('LT_Role_Image') ?? session('Path_Role_image'),
            ])

            <div class="idc-content">

                <div class="idc-card anim-fade-up">
                    <div class="card-head">
                        <div>
                            <h6><i class="bi bi-calendar3 me-2 text-gradient"></i>Patient Submissions</h6>
                            <div class="sub">Every sample intake, plotted on the day it was registered — click a patient to see details &amp; barcode</div>
                        </div>
                        <div class="d-flex gap-3 flex-wrap">
                            <span class="lg d-flex align-items-center gap-2 small fw-bold"><span class="sw" style="width:11px;height:11px;border-radius:4px;background:#f59e0b;display:inline-block;"></span>Awaiting review</span>
                            <span class="lg d-flex align-items-center gap-2 small fw-bold"><span class="sw" style="width:11px;height:11px;border-radius:4px;background:#10b981;display:inline-block;"></span>Treated</span>
                        </div>
                    </div>
                    <div class="card-inner idc-calendar">
                        <div id="submissionCalendar"></div>
                    </div>
                </div>

            </div>

            <footer class="idc-footer">
                <span>© {{ date('Y') }} IDC Portal — Muhammad Uzair Ishfaq &amp; Khadija Ibrahim</span>
                <span><i class="bi bi-cpu me-1"></i>AI-assisted histopathology</span>
            </footer>
        </div>
    </div>

    {{-- ===== Submission detail modal ===== --}}
    <div id="submissionModal" class="modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <span class="mi"><i class="bi bi-person-vcard"></i></span>
                        <span id="smName">Patient</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-wrap gap-2 mb-3" id="smBadges"></div>
                    <div class="row g-3">
                        <div class="col-sm-6"><div class="info-tile"><div class="it-label">Sample No</div><div class="it-value" id="smSample">—</div></div></div>
                        <div class="col-sm-6"><div class="info-tile"><div class="it-label">Registered</div><div class="it-value" id="smDate">—</div></div></div>
                        <div class="col-sm-6"><div class="info-tile"><div class="it-label">Contact</div><div class="it-value" id="smContact">—</div></div></div>
                        <div class="col-sm-6"><div class="info-tile"><div class="it-label">Added By (LT)</div><div class="it-value" id="smAddedby">—</div></div></div>
                    </div>
                    <div class="text-center mt-4">
                        <div class="barcode-card">
                            <svg id="smBarcode"></svg>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" id="smLabel" class="btn btn-soft"><i class="bi bi-upc me-1"></i>Print Barcode</a>
                    <a href="#" id="smReceipt" class="btn btn-soft"><i class="bi bi-receipt me-1"></i>Receipt</a>
                    <a href="#" id="smProfile" class="btn btn-gradient"><i class="bi bi-person-lines-fill me-1"></i>Open Profile</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var events = @json($calendar_events);
            events.forEach(function (ev) {
                ev.className = ev.extendedProps.treated == '1' ? 'ev-treated' : 'ev-pending';
            });

            var calendar = new FullCalendar.Calendar(document.getElementById('submissionCalendar'), {
                initialView: 'dayGridMonth',
                height: 'auto',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,listWeek'
                },
                buttonText: { today: 'Today', month: 'Month', list: 'Agenda' },
                dayMaxEventRows: 4,
                events: events,
                eventClick: function (info) {
                    var p = info.event.extendedProps;

                    $('#smName').text(p.name);
                    $('#smSample').text('#' + p.sampleno);
                    $('#smDate').text(p.date);
                    $('#smContact').text(p.contactno);
                    $('#smAddedby').text(p.addedby);

                    var badges = '';
                    if (p.result === 'Positive') {
                        badges += '<span class="badge-soft badge-soft-danger"><span class="dot"></span>IDC Positive</span>';
                    } else if (p.result === 'Negative') {
                        badges += '<span class="badge-soft badge-soft-success"><span class="dot"></span>IDC Negative</span>';
                    } else {
                        badges += '<span class="badge-soft badge-soft-warning"><span class="dot"></span>Result Pending</span>';
                    }
                    badges += p.treated == '1'
                        ? '<span class="badge-soft badge-soft-info">Treated</span>'
                        : '<span class="badge-soft badge-soft-warning">In queue</span>';
                    $('#smBadges').html(badges);

                    $('#smProfile').attr('href', p.profile);
                    $('#smReceipt').attr('href', p.receipt);
                    $('#smLabel').attr('href', p.label);

                    JsBarcode('#smBarcode', p.sampleno, {
                        format: 'CODE128',
                        width: 2,
                        height: 52,
                        margin: 0,
                        displayValue: true,
                        fontSize: 13,
                        font: 'Plus Jakarta Sans',
                        fontOptions: 'bold',
                        textMargin: 5
                    });

                    new bootstrap.Modal(document.getElementById('submissionModal')).show();
                }
            });

            calendar.render();
        });
    </script>
@endpush
