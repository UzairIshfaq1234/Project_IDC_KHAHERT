@extends('app')

@section('pagetitle', 'Lab Technician Dashboard')

@section('content')
    <div class="idc-shell">

        @include('LT.LT_layout.LT_navbar')

        <div class="idc-main">

            @include('layouts.topbar', [
                'title' => 'Laboratory Dashboard',
                'crumb' => 'Lab Technician',
                'userName' => session('LT_Auth_Session'),
                'avatarFile' => session('LT_Role_Image'),
            ])

            <div class="idc-content">

                {{-- Hero banner --}}
                <div class="hero-banner anim-fade-up" style="background: var(--idc-grad-emerald); box-shadow: 0 20px 45px -18px rgba(16, 185, 129, .55);">
                    <span class="hero-deco d1"></span>
                    <span class="hero-deco d2"></span>
                    <span class="hero-badge mb-3"><i class="bi bi-eyedropper"></i> Laboratory Workspace</span>
                    <h4><span data-greeting>Welcome</span>, {{ session('LT_Auth_Session') }} 👋</h4>
                    <p>Register new samples, keep patient records up to date and track processing progress.</p>
                </div>

                {{-- KPI row --}}
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d1">
                            <span class="stat-glow bg-grad-sky"></span>
                            <div class="stat-icon bg-grad-sky"><i class="bi bi-calendar2-plus"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $total_patient_added_today_treated }}</div>
                                <div class="stat-label">Added Today</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d2">
                            <span class="stat-glow bg-grad-primary"></span>
                            <div class="stat-icon bg-grad-primary"><i class="bi bi-folder2-open"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_Patient_count }}</div>
                                <div class="stat-label">Total Patients</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d3">
                            <span class="stat-glow bg-grad-emerald"></span>
                            <div class="stat-icon bg-grad-emerald"><i class="bi bi-check2-circle"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_Treated_count }}</div>
                                <div class="stat-label">Treated Cases</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d4">
                            <span class="stat-glow bg-grad-amber"></span>
                            <div class="stat-icon bg-grad-amber"><i class="bi bi-hourglass-split"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_NotTreated_count }}</div>
                                <div class="stat-label">Awaiting Review</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row g-4 mb-4">
                    {{-- Processing chart --}}
                    <div class="col-lg-5">
                        <div class="idc-card h-100 anim-fade-up anim-d2">
                            <div class="card-head">
                                <div>
                                    <h6>Processing Status</h6>
                                    <div class="sub">Treated vs. awaiting pathology review</div>
                                </div>
                            </div>
                            <div class="card-inner">
                                <div class="chart-box mx-auto" style="height: 210px; max-width: 250px;">
                                    <canvas id="statusChart"></canvas>
                                </div>
                                <div class="mini-legend">
                                    <span class="lg"><span class="sw" style="background:#10b981;"></span>Treated · {{ $all_Treated_count }}</span>
                                    <span class="lg"><span class="sw" style="background:#f59e0b;"></span>Pending · {{ $all_NotTreated_count }}</span>
                                </div>
                                <div class="text-center mt-3 small text-muted fw-semibold">
                                    <i class="bi bi-info-circle me-1"></i>Last treated patient ID:
                                    <span class="fw-bold text-gradient">#{{ $last_updated_treated_record ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Quick actions + recent --}}
                    <div class="col-lg-7">
                        <div class="idc-card h-100 anim-fade-up anim-d3">
                            <div class="table-toolbar">
                                <div>
                                    <h6 class="mb-0 fw-bolder">Recently Registered</h6>
                                    <div class="text-muted small fw-semibold">Latest samples entered by the laboratory</div>
                                </div>
                                <a href="{{ route('patient.add') }}" class="btn btn-gradient btn-sm ms-auto">
                                    <i class="bi bi-plus-lg me-1"></i>New Patient
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-modern">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Sample No</th>
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
                                                <td>
                                                    @if ($p->treated == '1')
                                                        <span class="badge-soft badge-soft-success"><span class="dot"></span>Treated</span>
                                                    @else
                                                        <span class="badge-soft badge-soft-warning"><span class="dot"></span>In queue</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr data-empty-row>
                                                <td colspan="3">
                                                    <div class="empty-state">
                                                        <div class="es-icon"><i class="bi bi-clipboard2-data"></i></div>
                                                        <h6>No patients yet</h6>
                                                        <p>Start by registering a new patient sample.</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
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
        new Chart(document.getElementById('statusChart'), {
            type: 'doughnut',
            data: {
                labels: ['Treated', 'Awaiting review'],
                datasets: [{
                    data: [{{ $all_Treated_count }}, {{ $all_NotTreated_count }}],
                    backgroundColor: ['#10b981', '#f59e0b'],
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
    </script>
@endpush
