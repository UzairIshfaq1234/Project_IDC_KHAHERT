@extends('app')

@section('pagetitle', 'Pathologist Dashboard')

@section('content')
    <div class="idc-shell">

        @include('Pathologist.pathologist_layout.pathologist_navbar')

        <div class="idc-main">

            @include('layouts.topbar', [
                'title' => 'Pathologist Dashboard',
                'crumb' => 'Pathologist',
                'userName' => session('Path_Auth_Session'),
                'avatarFile' => session('Path_Role_image'),
            ])

            <div class="idc-content">

                {{-- Hero banner --}}
                <div class="hero-banner anim-fade-up" style="background: var(--idc-grad-rose); box-shadow: 0 20px 45px -18px rgba(236, 72, 153, .55);">
                    <span class="hero-deco d1"></span>
                    <span class="hero-deco d2"></span>
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div>
                            <span class="hero-badge mb-3"><i class="bi bi-clipboard2-pulse"></i> Pathology Workspace</span>
                            <h4><span data-greeting>Welcome</span>, Dr. {{ session('Path_Auth_Session') }} 👋</h4>
                            <p>{{ $all_NotTreated_count }} case{{ $all_NotTreated_count == 1 ? '' : 's' }} awaiting your diagnostic review.</p>
                        </div>
                        <a href="http://127.0.0.1:5000/" target="_blank" class="btn btn-ai">
                            <i class="bi bi-cpu me-2"></i>Launch AI Detection Engine
                        </a>
                    </div>
                </div>

                {{-- KPI row --}}
                <div class="row g-4 mb-4">
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d1">
                            <span class="stat-glow bg-grad-sky"></span>
                            <div class="stat-icon bg-grad-sky"><i class="bi bi-calendar2-plus"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $total_patient_added_today_treated }}</div>
                                <div class="stat-label">Cases Added Today</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d2">
                            <span class="stat-glow bg-grad-rose"></span>
                            <div class="stat-icon bg-grad-rose"><i class="bi bi-person-check"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $patientsTreatedByDoctorCount }}</div>
                                <div class="stat-label">Treated By You</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3">
                        <div class="idc-card stat-card anim-fade-up anim-d3">
                            <span class="stat-glow bg-grad-emerald"></span>
                            <div class="stat-icon bg-grad-emerald"><i class="bi bi-check2-circle"></i></div>
                            <div>
                                <div class="stat-value counter">{{ $all_Treated_count }}</div>
                                <div class="stat-label">Total Treated</div>
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
                    {{-- Performance breakdown --}}
                    <div class="col-lg-5">
                        <div class="idc-card h-100 anim-fade-up anim-d2">
                            <div class="card-head">
                                <div>
                                    <h6>Caseload Overview</h6>
                                    <div class="sub">Relative distribution across all cases</div>
                                </div>
                            </div>
                            <div class="card-inner">
                                @php
                                    $max = max($all_Patient_count, 1);
                                @endphp
                                <div class="progress-row">
                                    <div class="p-head">
                                        <span>Cases added today</span>
                                        <span class="p-val text-primary">{{ $total_patient_added_today_treated }}</span>
                                    </div>
                                    <div class="progress-modern progress">
                                        <div class="progress-bar bg-grad-sky" role="progressbar"
                                            style="width: {{ min(round($total_patient_added_today_treated / $max * 100), 100) }}%"></div>
                                    </div>
                                </div>
                                <div class="progress-row">
                                    <div class="p-head">
                                        <span>Treated by you</span>
                                        <span class="p-val" style="color:#ec4899;">{{ $patientsTreatedByDoctorCount }}</span>
                                    </div>
                                    <div class="progress-modern progress">
                                        <div class="progress-bar bg-grad-rose" role="progressbar"
                                            style="width: {{ min(round($patientsTreatedByDoctorCount / $max * 100), 100) }}%"></div>
                                    </div>
                                </div>
                                <div class="progress-row">
                                    <div class="p-head">
                                        <span>Total treated</span>
                                        <span class="p-val text-success">{{ $all_Treated_count }}</span>
                                    </div>
                                    <div class="progress-modern progress">
                                        <div class="progress-bar bg-grad-emerald" role="progressbar"
                                            style="width: {{ min(round($all_Treated_count / $max * 100), 100) }}%"></div>
                                    </div>
                                </div>
                                <div class="progress-row mb-0">
                                    <div class="p-head">
                                        <span>Awaiting review</span>
                                        <span class="p-val text-warning">{{ $all_NotTreated_count }}</span>
                                    </div>
                                    <div class="progress-modern progress">
                                        <div class="progress-bar bg-grad-amber" role="progressbar"
                                            style="width: {{ min(round($all_NotTreated_count / $max * 100), 100) }}%"></div>
                                    </div>
                                </div>

                                <div class="text-center mt-4 small text-muted fw-semibold">
                                    <i class="bi bi-info-circle me-1"></i>Last treated patient ID:
                                    <span class="fw-bold text-gradient">#{{ $last_updated_treated_record ?? '—' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pending queue --}}
                    <div class="col-lg-7">
                        <div class="idc-card h-100 anim-fade-up anim-d3">
                            <div class="table-toolbar">
                                <div>
                                    <h6 class="mb-0 fw-bolder">Review Queue</h6>
                                    <div class="text-muted small fw-semibold">Samples awaiting diagnostic review</div>
                                </div>
                                <a href="{{ route('Path.Appointments') }}" class="btn btn-gradient btn-sm ms-auto">
                                    Open appointments <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-modern">
                                    <thead>
                                        <tr>
                                            <th>Patient</th>
                                            <th>Sample No</th>
                                            <th>Registered</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pending_queue as $p)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center gap-3">
                                                        <span class="avatar avatar-sm avatar-grad-{{ ($loop->index % 5) + 1 }}">{{ strtoupper(substr($p->Name, 0, 2)) }}</span>
                                                        <div>
                                                            <div class="cell-title">{{ $p->Name }}</div>
                                                            <div class="cell-sub">{{ $p->Addedby }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><span class="badge-soft badge-soft-violet">#{{ $p->Sampleno }}</span></td>
                                                <td class="cell-sub">{{ $p->created_at ? $p->created_at->diffForHumans() : '—' }}</td>
                                            </tr>
                                        @empty
                                            <tr data-empty-row>
                                                <td colspan="3">
                                                    <div class="empty-state">
                                                        <div class="es-icon"><i class="bi bi-check2-all"></i></div>
                                                        <h6>All caught up!</h6>
                                                        <p>No cases are waiting for review.</p>
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
