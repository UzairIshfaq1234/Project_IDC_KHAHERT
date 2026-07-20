{{-- Shared topbar — expects: $title, $crumb, $userName, $avatarFile --}}
<header class="idc-topbar">
    <button class="topbar-toggle" type="button" data-sidebar-toggle aria-label="Toggle menu">
        <i class="bi bi-list"></i>
    </button>

    <div class="topbar-title">
        <h5>{{ $title }}</h5>
        <div class="crumb"><i class="bi bi-house-door me-1"></i>IDC Portal · {{ $crumb }}</div>
    </div>

    <div class="topbar-clock">
        <div class="t-time" data-clock-time>--:--</div>
        <div class="t-date" data-clock-date></div>
    </div>

    @php
        $alert_pending = \App\Models\idc_patient::where('treated', '0')->latest('created_at')->take(5)->get();
        $alert_pending_count = \App\Models\idc_patient::where('treated', '0')->count();
        $alert_today_count = \App\Models\idc_patient::whereDate('created_at', today())->count();
        $alert_results_today = \App\Models\idc_patient::where('treated', '1')->whereDate('updated_at', today())->count();
    @endphp

    <div class="dropdown">
        <button class="topbar-btn alert-bell" type="button" data-bs-toggle="dropdown" aria-expanded="false"
            title="Alerts">
            <i class="bi bi-bell"></i>
            @if ($alert_pending_count > 0)
                <span class="bell-badge">{{ $alert_pending_count > 99 ? '99+' : $alert_pending_count }}</span>
            @endif
        </button>
        <div class="dropdown-menu dropdown-menu-end alerts-menu shadow mt-2">
            <div class="am-head">
                <span><i class="bi bi-bell me-2"></i>Alerts</span>
                <span class="badge rounded-pill">{{ $alert_today_count }} new today</span>
            </div>
            <div class="am-body">
                @if ($alert_results_today > 0)
                    <div class="alert-item">
                        <span class="ai-icon" style="background: rgba(16,185,129,.13); color:#059669;"><i class="bi bi-clipboard2-check"></i></span>
                        <div>
                            <div class="ai-title">{{ $alert_results_today }} result{{ $alert_results_today == 1 ? '' : 's' }} recorded today</div>
                            <div class="ai-sub">Diagnostic reports are ready to print</div>
                        </div>
                    </div>
                @endif
                @forelse ($alert_pending as $ap)
                    <a class="alert-item" href="{{ route('patient.profile', ['id' => $ap->Id]) }}">
                        <span class="ai-icon" style="background: rgba(245,158,11,.14); color:#b45309;"><i class="bi bi-hourglass-split"></i></span>
                        <div>
                            <div class="ai-title">{{ $ap->Name }} — awaiting review</div>
                            <div class="ai-sub">Sample #{{ $ap->Sampleno }} · {{ $ap->created_at ? $ap->created_at->diffForHumans() : '' }}</div>
                        </div>
                    </a>
                @empty
                    <div class="alert-item">
                        <span class="ai-icon" style="background: rgba(16,185,129,.13); color:#059669;"><i class="bi bi-check2-all"></i></span>
                        <div>
                            <div class="ai-title">All caught up!</div>
                            <div class="ai-sub">No samples are waiting for review</div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="am-foot">
                <a href="{{ route('patient.calendar') }}"><i class="bi bi-calendar3 me-1"></i>Open submissions calendar</a>
            </div>
        </div>
    </div>

    <button class="topbar-btn" type="button" data-theme-toggle title="Toggle dark mode">
        <i class="bi bi-moon-stars"></i>
    </button>

    <button class="topbar-btn d-none d-sm-grid" type="button" data-fullscreen-toggle title="Fullscreen">
        <i class="bi bi-arrows-fullscreen"></i>
    </button>

    <div class="dropdown">
        <button class="topbar-avatar-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
            @if (!empty($avatarFile))
                <img src="{{ asset('Admin_Images/' . $avatarFile) }}" alt="{{ $userName }}" class="avatar">
            @else
                <span class="avatar">{{ strtoupper(substr($userName ?? 'U', 0, 2)) }}</span>
            @endif
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="border-radius: 14px;">
            <li class="px-3 py-2">
                <div class="fw-bold">{{ $userName }}</div>
                <div class="small text-muted">{{ $crumb }}</div>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item fw-semibold" href="{{ route('profile.my') }}">
                    <i class="bi bi-person-circle me-2"></i>My Profile
                </a>
            </li>
            <li>
                <a class="dropdown-item text-danger fw-semibold" href="{{ route('Page.logout') }}">
                    <i class="bi bi-box-arrow-right me-2"></i>Sign out
                </a>
            </li>
        </ul>
    </div>
</header>
