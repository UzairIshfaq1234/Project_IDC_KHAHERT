@extends('app')

@section('pagetitle', 'Barcode Scanner')

@section('content')
    <div class="idc-shell">

        @include('LT.LT_layout.LT_navbar')

        <div class="idc-main">

            @include('layouts.topbar', [
                'title' => 'Barcode Scanner',
                'crumb' => 'Lab Technician · Patient Lookup',
                'userName' => session('LT_Auth_Session'),
                'avatarFile' => session('LT_Role_Image'),
            ])

            <div class="idc-content">

                <div class="scan-panel anim-fade-up">
                    <span class="blob b1"></span>
                    <span class="blob b2"></span>

                    <div class="text-center mb-4" style="position:relative;">
                        <h5 class="text-white fw-bold mb-1"><i class="bi bi-upc-scan me-2"></i>Scan a Sample Barcode</h5>
                        <p class="mb-0" style="color:#8b96b5;font-size:.85rem;font-weight:600;">
                            Point the camera at a printed sample label, or type the sample number manually to open the patient's journey.
                        </p>
                    </div>

                    <div class="scan-viewport" id="scanViewport" style="position:relative;">
                        <video id="scanVideo" autoplay playsinline muted></video>

                        <div class="scan-off" id="scanOff">
                            <div>
                                <div class="so-icon"><i class="bi bi-camera-video"></i></div>
                                <h6>Camera is off</h6>
                                <p>Press <b style="color:#c4b5fd;">Start Scanning</b> and allow camera access</p>
                            </div>
                        </div>

                        <div class="scan-frame d-none" id="scanFrame">
                            <span class="corner tl"></span>
                            <span class="corner tr"></span>
                            <span class="corner bl"></span>
                            <span class="corner br"></span>
                            <span class="scan-beam"></span>
                        </div>
                    </div>

                    <div class="scan-controls">
                        <button type="button" class="btn btn-gradient" id="startScanBtn">
                            <i class="bi bi-play-fill me-1"></i>Start Scanning
                        </button>
                        <button type="button" class="btn btn-soft" id="stopScanBtn" disabled>
                            <i class="bi bi-stop-fill me-1"></i>Stop Camera
                        </button>
                    </div>

                    <div class="manual-entry">
                        <input type="text" id="manualCode" placeholder="…or type sample number manually, e.g. S-2026-001" autocomplete="off">
                        <button type="button" class="btn btn-ai" id="manualLookupBtn">
                            <i class="bi bi-search me-1"></i>Lookup
                        </button>
                    </div>

                    <div id="scanResultWrap"></div>

                    <div class="scan-history d-none" id="scanHistoryWrap">
                        <h6><i class="bi bi-clock-history me-1"></i>Recent Lookups</h6>
                        <div id="scanHistoryList"></div>
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
    <script src="https://cdn.jsdelivr.net/npm/@zxing/library@0.20.0/umd/index.min.js"></script>
    <script>
        $(document).ready(function () {
            var video = document.getElementById('scanVideo');
            var scanOff = document.getElementById('scanOff');
            var scanFrame = document.getElementById('scanFrame');
            var startBtn = document.getElementById('startScanBtn');
            var stopBtn = document.getElementById('stopScanBtn');
            var manualInput = document.getElementById('manualCode');
            var history = [];

            var codeReader = (typeof ZXing !== 'undefined') ? new ZXing.BrowserMultiFormatReader() : null;
            var scanning = false;

            startBtn.addEventListener('click', function () {
                if (!codeReader) {
                    Swal.fire({ icon: 'error', title: 'Scanner unavailable', text: 'The barcode scanning library failed to load. Please use manual entry.' });
                    return;
                }
                scanOff.style.display = 'none';
                scanFrame.classList.remove('d-none');
                startBtn.disabled = true;
                stopBtn.disabled = false;
                scanning = true;

                codeReader.decodeFromVideoDevice(null, video, function (result, err) {
                    if (result && scanning) {
                        var text = result.getText();
                        doLookup(text);
                    }
                });
            });

            stopBtn.addEventListener('click', stopScan);

            function stopScan() {
                scanning = false;
                if (codeReader) codeReader.reset();
                scanOff.style.display = 'grid';
                scanFrame.classList.add('d-none');
                startBtn.disabled = false;
                stopBtn.disabled = true;
            }

            document.getElementById('manualLookupBtn').addEventListener('click', function () {
                if (manualInput.value.trim()) doLookup(manualInput.value.trim());
            });
            manualInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    if (manualInput.value.trim()) doLookup(manualInput.value.trim());
                }
            });

            var lastCode = null;
            var lastLookupAt = 0;

            function doLookup(code) {
                var now = Date.now();
                if (code === lastCode && (now - lastLookupAt) < 2500) return; // debounce repeat frames
                lastCode = code;
                lastLookupAt = now;

                $.ajax({
                    url: @json(route('patient.barcodelookup')),
                    type: 'POST',
                    data: { code: code, _token: @json(csrf_token()) },
                    success: function (response) {
                        if (response.found) {
                            renderResult(response.patient);
                            pushHistory(response.patient);
                        } else {
                            renderNotFound(code);
                        }
                    },
                    error: function () {
                        Swal.fire({ icon: 'error', title: 'Lookup failed', text: 'Something went wrong. Please try again.' });
                    }
                });
            }

            function badge(text, cls) {
                return '<span class="badge-soft ' + cls + '"><span class="dot"></span>' + text + '</span>';
            }

            function renderResult(p) {
                var resultBadge = p.result === 'Positive'
                    ? badge('IDC Positive', 'badge-soft-danger')
                    : p.result === 'Negative'
                        ? badge('IDC Negative', 'badge-soft-success')
                        : badge('Result Pending', 'badge-soft-warning');
                var statusBadge = p.treated == '1'
                    ? '<span class="badge-soft badge-soft-info">Treated</span>'
                    : '<span class="badge-soft badge-soft-warning">In queue</span>';

                var reportBtn = p.report
                    ? '<a href="' + p.report + '" class="btn btn-soft btn-sm"><i class="bi bi-file-earmark-medical me-1"></i>Report</a>'
                    : '';

                var html = ''
                    + '<div class="scan-result-card">'
                    + '  <div class="src-head">'
                    + '    <span class="avatar avatar-grad-2">' + p.name.substring(0, 2).toUpperCase() + '</span>'
                    + '    <div>'
                    + '      <div class="src-name">' + p.name + '</div>'
                    + '      <div class="src-sub">#' + p.sampleno + ' · registered ' + p.date + '</div>'
                    + '    </div>'
                    + '  </div>'
                    + '  <div class="d-flex flex-wrap gap-2">' + resultBadge + statusBadge + '</div>'
                    + '  <div class="src-actions">'
                    + '    <a href="' + p.profile + '" class="btn btn-gradient btn-sm"><i class="bi bi-person-lines-fill me-1"></i>Open Journey</a>'
                    + '    <a href="' + p.receipt + '" class="btn btn-soft btn-sm"><i class="bi bi-receipt me-1"></i>Receipt</a>'
                    + '    <a href="' + p.label + '" class="btn btn-soft btn-sm"><i class="bi bi-upc me-1"></i>Label</a>'
                    + reportBtn
                    + '  </div>'
                    + '</div>';

                $('#scanResultWrap').html(html);
            }

            function renderNotFound(code) {
                var html = ''
                    + '<div class="scan-result-card">'
                    + '  <div class="d-flex align-items-center gap-3">'
                    + '    <span class="avatar" style="background: linear-gradient(135deg,#dc2626,#f43f5e);"><i class="bi bi-exclamation-triangle"></i></span>'
                    + '    <div>'
                    + '      <div class="src-name">No match found</div>'
                    + '      <div class="src-sub">Code "' + code.replace(/</g, '&lt;') + '" does not match any registered sample</div>'
                    + '    </div>'
                    + '  </div>'
                    + '</div>';
                $('#scanResultWrap').html(html);
            }

            function pushHistory(p) {
                history = history.filter(function (h) { return h.sampleno !== p.sampleno; });
                history.unshift(p);
                history = history.slice(0, 6);

                var rows = history.map(function (h) {
                    return '<div class="scan-history-item" data-sample="' + h.sampleno.replace(/"/g, '&quot;') + '">'
                        + '  <span class="avatar avatar-sm avatar-grad-3">' + h.name.substring(0, 2).toUpperCase() + '</span>'
                        + '  <span class="shi-name">' + h.name + '</span>'
                        + '  <span class="shi-sample">#' + h.sampleno + '</span>'
                        + '</div>';
                }).join('');

                $('#scanHistoryList').html(rows);
                $('#scanHistoryWrap').removeClass('d-none');
            }

            $(document).on('click', '.scan-history-item', function () {
                doLookup($(this).data('sample').toString());
            });

            window.addEventListener('beforeunload', function () {
                if (codeReader) codeReader.reset();
            });
        });
    </script>
@endpush
