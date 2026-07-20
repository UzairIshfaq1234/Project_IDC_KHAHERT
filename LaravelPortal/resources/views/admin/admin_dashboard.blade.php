@extends('app')

@section('pagetitle', 'Admin Dashboard')

@section('content')
    <div class="idc-shell">

        @include('admin.admin_layout.admin_navbar')

        <div class="idc-main">

            @include('layouts.topbar', [
                'title' => 'Admin Dashboard',
                'crumb' => 'Administrator',
                'userName' => session('Admin_Auth_Session'),
                'avatarFile' => session('Admin_Role_Image'),
            ])

            <div class="idc-content">

                {{-- Hero banner --}}
                <div class="hero-banner anim-fade-up">
                    <span class="hero-deco d1"></span>
                    <span class="hero-deco d2"></span>
                    <span class="hero-badge mb-3"><i class="bi bi-shield-check"></i> Administrator Console</span>
                    <h4><span data-greeting>Welcome</span>, {{ session('Admin_Auth_Session') }} 👋</h4>
                    <p>Here's the live overview of your diagnostic center — team, cases and AI screening results.</p>
                </div>

                {{-- KPI row: team --}}
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-xl-4">
                        <div class="idc-card stat-card anim-fade-up anim-d1">
                            <span class="stat-glow bg-grad-primary"></span>
                            <div class="stat-icon bg-grad-primary"><i class="bi bi-person-badge"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_admin_count }}</div>
                                <div class="stat-label">Total Logins</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="idc-card stat-card anim-fade-up anim-d2">
                            <span class="stat-glow bg-grad-emerald"></span>
                            <div class="stat-icon bg-grad-emerald"><i class="bi bi-eyedropper"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_LT_count }}</div>
                                <div class="stat-label">Lab Technicians</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-4">
                        <div class="idc-card stat-card anim-fade-up anim-d3">
                            <span class="stat-glow bg-grad-rose"></span>
                            <div class="stat-icon bg-grad-rose"><i class="bi bi-clipboard2-pulse"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_Path_count }}</div>
                                <div class="stat-label">Pathologists</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Charts row --}}
                <div class="row g-4 mb-4">
                    <div class="col-lg-7">
                        <div class="idc-card h-100 anim-fade-up anim-d2">
                            <div class="card-head">
                                <div>
                                    <h6>Case Intake Trend</h6>
                                    <div class="sub">Patients registered over the last 6 months</div>
                                </div>
                                <span class="badge-soft badge-soft-primary"><span class="dot"></span>Live data</span>
                            </div>
                            <div class="card-inner">
                                <div class="chart-box" style="height: 265px;">
                                    <canvas id="trendChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="idc-card h-100 anim-fade-up anim-d3">
                            <div class="card-head">
                                <div>
                                    <h6>Diagnosis Outcomes</h6>
                                    <div class="sub">IDC screening results distribution</div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="chart-box mx-auto" style="height: 220px; max-width: 260px;">
                                    <canvas id="resultChart"></canvas>
                                </div>
                                <div class="mini-legend">
                                    <span class="lg"><span class="sw" style="background:#f43f5e;"></span>Positive · {{ $all_Postive_count }}</span>
                                    <span class="lg"><span class="sw" style="background:#10b981;"></span>Negative · {{ $all_Negative_count }}</span>
                                    <span class="lg"><span class="sw" style="background:#94a3b8;"></span>Pending · {{ max($all_Patient_count - $all_Postive_count - $all_Negative_count, 0) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Cases KPIs + progress --}}
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d1">
                            <div class="stat-icon bg-grad-sky"><i class="bi bi-folder2-open"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_Patient_count }}</div>
                                <div class="stat-label">Total Cases</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d2">
                            <div class="stat-icon bg-grad-rose"><i class="bi bi-virus"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_Postive_count }}</div>
                                <div class="stat-label">Positive Cases</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d3">
                            <div class="stat-icon bg-grad-emerald"><i class="bi bi-check2-circle"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_Treated_count }}</div>
                                <div class="stat-label">Treated Cases</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d4">
                            <div class="stat-icon bg-grad-amber"><i class="bi bi-hourglass-split"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_NotTreated_count }}</div>
                                <div class="stat-label">Awaiting Review</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Recent patients --}}
                <div class="idc-card anim-fade-up anim-d4 mb-2">
                    <div class="table-toolbar">
                        <div>
                            <h6 class="mb-0 fw-bolder">Recent Patients</h6>
                            <div class="sub text-muted small fw-semibold">Latest samples registered in the laboratory</div>
                        </div>
                        <a href="{{ route('patient.allpatient') }}" class="btn btn-soft btn-sm ms-auto">
                            View all <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-modern">
                            <thead>
                                <tr>
                                    <th>Patient</th>
                                    <th>Sample No</th>
                                    <th>Added By</th>
                                    <th>Result</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recent_patients as $p)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="avatar avatar-sm avatar-grad-{{ ($loop->index % 5) + 1 }}">{{ strtoupper(substr($p->Name, 0, 2)) }}</span>
                                                <div>
                                                    <div class="cell-title">{{ $p->Name }}</div>
                                                    <div class="cell-sub">{{ $p->Email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span class="badge-soft badge-soft-violet">#{{ $p->Sampleno }}</span></td>
                                        <td>{{ $p->Addedby }}</td>
                                        <td>
                                            @if ($p->Result === 'Positive')
                                                <span class="badge-soft badge-soft-danger"><span class="dot"></span>Positive</span>
                                            @elseif ($p->Result === 'Negative')
                                                <span class="badge-soft badge-soft-success"><span class="dot"></span>Negative</span>
                                            @else
                                                <span class="badge-soft badge-soft-warning"><span class="dot"></span>Pending</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($p->treated == '1')
                                                <span class="badge-soft badge-soft-info">Treated</span>
                                            @else
                                                <span class="badge-soft badge-soft-warning">In queue</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr data-empty-row>
                                        <td colspan="5">
                                            <div class="empty-state">
                                                <div class="es-icon"><i class="bi bi-clipboard2-data"></i></div>
                                                <h6>No patients yet</h6>
                                                <p>Registered patients will appear here.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
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
        (function () {
            var trendCtx = document.getElementById('trendChart');
            new Chart(trendCtx, {
                type: 'bar',
                data: {
                    labels: @json($trend_labels),
                    datasets: [{
                        label: 'Total intake',
                        data: @json($trend_total),
                        backgroundColor: 'rgba(99, 102, 241, .85)',
                        hoverBackgroundColor: '#4f46e5',
                        borderRadius: 8,
                        maxBarThickness: 34
                    }, {
                        label: 'Positive',
                        data: @json($trend_positive),
                        backgroundColor: 'rgba(244, 63, 94, .8)',
                        hoverBackgroundColor: '#e11d48',
                        borderRadius: 8,
                        maxBarThickness: 34
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(148, 163, 184, .15)' } }
                    }
                }
            });

            var resultCtx = document.getElementById('resultChart');
            new Chart(resultCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Positive', 'Negative', 'Pending'],
                    datasets: [{
                        data: [
                            {{ $all_Postive_count }},
                            {{ $all_Negative_count }},
                            {{ max($all_Patient_count - $all_Postive_count - $all_Negative_count, 0) }}
                        ],
                        backgroundColor: ['#f43f5e', '#10b981', '#94a3b8'],
                        borderWidth: 0,
                        hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '68%',
                    plugins: { legend: { display: false } }
                }
            });
        })();
    </script>
@endpush
